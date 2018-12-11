<?php
/**
 * Модель для загрузки файла
 */

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadDocument extends Model
{
    /**
     * @var UploadedFile
     */
    public $uploadedFile;

    /** @var string Папка для сохранения */
    public $folderSave = 'documents';

    /**
     * Наименование файла
     * @var string
     */
    public $nameFile;

    public function rules()
    {
        return [
            [
                ['uploadedFile'], 'file', 'skipOnEmpty' => false,
            ],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->uploadedFile->saveAs($this->getFullPath());
            return true;
        } else {
            return false;
        }
    }

    public function getFullPath($fileName = null){
        return $this->getPathSave() . DIRECTORY_SEPARATOR . (is_null($fileName) ? $this->nameFile : $fileName);
    }

    public function getPathSave(){
        $path = Yii::$app->params['pathUploads'] . DIRECTORY_SEPARATOR . $this->folderSave;
        /** Проверка существования папки */
        if(!is_dir($path)){
            mkdir($path, 0777, true);
        }

        return $path;
    }

    public function getErrorUpload(){
        return $this->getFirstError('uploadedFile');
    }

    public function getInitialPreview(){
        return [
        ];
    }

    public function getInitialPreviewConfig(){
        return [
        ];
    }


    public function delete(){
        $fullPath = $this->getFullPath();
        if(is_file($fullPath)){
            unlink($fullPath);
        }
    }
}