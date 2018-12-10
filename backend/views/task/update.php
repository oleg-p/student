<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = Yii::t('app', 'Прикрепление результата: '. $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Прикрепление результата');
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-link-result', [
        'model' => $model,
    ]) ?>

</div>
