<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchies\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use common\dictionaries\Status;
use backend\helpers\AppHelper;

$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Task'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php 
    $gridColumn = [
        //['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'manager_id',
                'label' => Yii::t('app', 'Manager'),
                'value' => function($model){
                    if ($model->manager) {
                        return $model->manager->username;
                    }
                    else {
                        return NULL;
                    }
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->asArray()->all(), 'id', 'username'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Менеджер', 'id' => 'grid-task-search-manager_id']
            ],
        [
                'attribute' => 'executor_id',
                'label' => Yii::t('app', 'Executor'),
                'value' => function($model){
                    if ($model->executor)
                    {return $model->executor->username;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->asArray()->all(), 'id', 'username'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Исполнитель', 'id' => 'grid-task-search-executor_id']
            ],
        'name',
        'comment:ntext',
        'link_lecture',
        [
            'attribute' => 'file',
            'format' => 'raw',
            'filter' => false,
            'value' => function($model){
                if ($model->file) {
                    return Html::a($model->file, $model->getFileUrl(), [
                        'download' => true,
                        'data' => ['pjax' => '0']
                    ]);
                } else {
                    return null;
                }
            },
        ],
        [
            'attribute' => 'status',
            'filter' => Status::items(),
            'value' =>  function($model){
                return Status::getValue($model->status);
            }
        ],
        'created_at:date:Создано',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{take} {update} {delete}',
            'contentOptions' => ['class' => 'notFormEdit'],
            'buttons' => [
                'take' => function ($url, $model) {
                    if($model->status === Status::STATUS_NEW && AppHelper::isExecutor() && $model->getCountTaskInProgress() < \common\models\Task::LIMIT_TASKS_IN_PROGRESS){
                        return Html::a(
                            '<span class="glyphicon glyphicon-play"></span>',
                            $url,
                            ['title' => 'Взять задание на выполнение', 'data' => [
                                'pjax'=> '0',
                                'confirm' => 'Взять задание на выполнение?',
                                'method' => 'post',
                            ]]
                        );
                    }
                    return '';
                },
                'delete' => function ($url, $model) {
                    if($model->status === Status::STATUS_NEW && AppHelper::isManager()){
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $url,
                            ['title' => 'Удалить', 'data' => [
                                'pjax'=> '0',
                                'confirm' => 'Вы уверены, что хотите удалить это задание?',
                                'method' => 'post',
                            ]]
                        );
                    }
                    return '';
                },
                'update' => function ($url, $model) {
                    if($model->status === Status::STATUS_IN_PROGRESS && AppHelper::isExecutor() && $model->executor_id == Yii::$app->user->id){
                        return Html::a(
                            '<span class="glyphicon glyphicon-save"></span>',
                            $url,
                            ['title' => 'Прикрепить результат', 'data' => ['pjax' => '0']]
                        );
                    }
                    return '';
                },
            ],
        ],
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-task']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]) ,
        ],
    ]); ?>

</div>
