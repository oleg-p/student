<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchies\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use common\dictionaries\Role;

$this->title = Yii::t('app', 'Users');

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $gridColumn = [
        //['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'username:html:Логин',
        'email:email:Электронная почта',
        //'status',
        [
            'attribute' => 'role',
            'label' => 'Роль',
            'filter' => Role::items(),
            'value' =>  function($model){
                return Role::getValue($model->role);
            }
        ],
//        [
//            'class' => 'yii\grid\ActionColumn',
//        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-user']],
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
