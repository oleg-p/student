<?php

namespace common\models;

use \common\models\base\Task as BaseTask;

/**
 * This is the model class for table "task".
 */
class Task extends BaseTask
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'executor_id'], 'integer'],
            [['comment', 'status'], 'string'],
            [['status'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'link_lecture', 'file'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],


        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
//            'id' => Yii::t('app', 'ID'),
//            'manager_id' => Yii::t('app', 'Менеджер'),
//            'executor_id' => Yii::t('app', 'Исполнитель'),
//            'name' => Yii::t('app', 'Наименование'),
//            'comment' => Yii::t('app', 'Комментарий'),
//            'link_lecture' => Yii::t('app', 'Ссылка на лекцию'),
//            'file' => Yii::t('app', 'Файл'),
//            'status' => Yii::t('app', 'Состояние'),
        ];
    }
}
