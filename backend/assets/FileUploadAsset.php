<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 11.12.2018
 * Time: 10:54
 */

namespace backend\assets;


use yii\web\AssetBundle;

class FileUploadAsset extends AssetBundle
{
    public $sourcePath = '@files/web/uploads/documents';

    public $publishOptions = ['forceCopy' => YII_DEBUG];
}