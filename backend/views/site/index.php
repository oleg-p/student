<?php

/* @var $this yii\web\View */

use backend\helpers\AppHelper;
use yii\helpers\Html;

$this->title = 'Работа с конспектами';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Тестовое задание</h1>

        <p class="lead">Работа с конспектами</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <p>
                    <?= Html::a('Задания &raquo;', ['/task/index'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
            <?php if(AppHelper::isAdmin()){ ?>
                <div class="col-lg-6">
                    <p>
                        <?= Html::a('Пользователи &raquo;', ['/user/index'], ['class' => 'btn btn-default']) ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
