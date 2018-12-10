<?php

namespace common\models;

use Yii;
use common\dictionaries\Status;
use \common\models\base\Task as BaseTask;
use backend\helpers\AppHelper;

/**
 * This is the model class for table "task".
 */
class Task extends BaseTask
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_LINK_RESULT = 'linkResult';

    const LIMIT_TASKS_IN_PROGRESS = 3;

    public $document;
    public $inputFilesDocum;
    public $inputOriginFilesDocum;

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
            [['link_lecture'], 'url', 'defaultScheme' => 'http'],

            [['name', 'link_lecture'], 'required', 'on' => self::SCENARIO_CREATE],
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

    public function beforeValidate()
    {
        parent::beforeValidate();

        if($this->scenario === self::SCENARIO_CREATE){
            //создание
            $this->status = Status::STATUS_NEW;
            $this->manager_id = Yii::$app->user->id;
        }

        return true;

    }

    /**
     * Назначает задание текущему пользователю
     * @return bool
     */
    public function setExecuter()
    {
        if(
            $this->status === Status::STATUS_NEW
            && AppHelper::isExecutor()
            && $this->getCountTaskInProgress() < self::LIMIT_TASKS_IN_PROGRESS
        ){
            $this->status = Status::STATUS_IN_PROGRESS;
            $this->executor_id = Yii::$app->user->id;

            return $this->save();
        }

        return false;
    }

    /**
     * Количесство заданий в работе активного пользоввтеля
     * @return int|string
     */
    public function getCountTaskInProgress()
    {
        return Task::find()
            ->andWhere(['executor_id' => Yii::$app->user->id])
            ->andWhere(['status' => Status::STATUS_IN_PROGRESS])
            ->count();
    }
}
