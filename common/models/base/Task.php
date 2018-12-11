<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "task".
 *
 * @property integer $id
 * @property integer $manager_id
 * @property integer $executor_id
 * @property string $name
 * @property string $comment
 * @property string $link_lecture
 * @property string $file
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \common\models\User $executor
 * @property \common\models\User $manager
 */
class Task extends \yii\db\ActiveRecord
{
    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'executor',
            'manager'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'manager_id' => Yii::t('app', 'Менеджер'),
            'executor_id' => Yii::t('app', 'Исполнитель'),
            'name' => Yii::t('app', 'Наименование'),
            'comment' => Yii::t('app', 'Комментарий'),
            'link_lecture' => Yii::t('app', 'Ссылка на лекцию'),
            'file' => Yii::t('app', 'Файл'),
            'status' => Yii::t('app', 'Состояние'),
            'inputFilesDocum' => Yii::t('app', 'Документ PDF'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'executor_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(\common\models\User::class, ['id' => 'manager_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }


    /**
     * @inheritdoc
     * @return \common\models\queries\TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\TaskQuery(get_called_class());
    }
}
