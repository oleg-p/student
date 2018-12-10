<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'manager_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
        'options' => [
                'placeholder' => Yii::t('app', 'Choose User'),
                'readonly' => true,
                'disabled' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput([
            'maxlength' => true, 'placeholder' => 'Name',
            'disabled' => true,
    ]) ?>

    <?= $form->field($model, 'comment')->textarea([
        'rows' => 6,
        'disabled' => true,
    ]) ?>

    <?= $form->field($model, 'link_lecture')->textInput([
        'maxlength' => true,
        'placeholder' => 'Link Lecture',
        'disabled' => true,
    ]) ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true, 'placeholder' => 'File']) ?>

    <div class="form-group">
        <div class="load-div-file load-document">
            <h4 class="text-center">Прикрепить документ PDF</h4>
            <?= \backend\widgets\PdfInput::widget([
                'model' => $model,
                'attribute' => 'document',
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
