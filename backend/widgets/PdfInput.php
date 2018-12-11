<?php
/**
 * Виджет загрузки pdf
 */

namespace backend\widgets;


use kartik\widgets\FileInput;
use yii\helpers\Html;

class PdfInput extends FileInput
{
    const PREFIX_NAME_FIELD = 'inputFiles';
    const PREFIX_ORIGIN_NAME_FIELD = 'inputOriginFiles';

    public $nameTypeFile  = 'Docum';

    public $autoOrientImages = false; //https://github.com/kartik-v/bootstrap-fileinput/issues/1286

    public $bsVersion = '3';

    /**
     * маршрут акции для загрузки
     * @var string
     */
    public $uploadUrl = 'upload-document';

    /**
     * маршрут акции для удаления изображения
     * @var string
     */
    public $deleteUrl = 'delete-document';

    public $options = [
        'multiple' => false,
    ];

    public function init()
    {
        parent::init();

        $this->pluginOptions['uploadUrl'] = $this->uploadUrl;
        $this->pluginOptions['deleteUrl'] = $this->deleteUrl;
        $this->pluginOptions['allowedFileExtensions'] = ['pdf'];
        $this->pluginOptions['uploadExtraData'] = [
            'nameImageField' => $this->model->formName() . '[document]',
        ];

        $this->pluginEvents['fileloaded'] = 'function(event, file, previewId, index, reader){'
            . '$(this).fileinput("upload");'
            . '}';

        $this->pluginEvents['fileuploaded'] = 'function(event, data, previewId, index){'
            . 'var inputNameLoadFile = $(this).closest("div.load-div-file").children("input.nameInputField");'
            . 'var inputNameOriginLoadFile = $(this).closest("div.load-div-file").children("input.nameOriginInputField");'
            . 'inputNameLoadFile.val(data.response.nameFile);'
            . 'inputNameOriginLoadFile.val(data.response.originNameFile);'

            . 'var signBlock = $(this).closest("div.form-group").children(".load-signature");'
            . 'if(signBlock.hasClass("hidden")){'
            . 'signBlock.removeClass("hidden")'
            . '}'
            . '}';
    }

    public function run() {
        echo Html::activeHiddenInput($this->model, $this->getFieldNameFile(), ['class' => 'nameInputField']);
        echo Html::activeHiddenInput($this->model, $this->getFieldOriginNameFile(), ['class' => 'nameOriginInputField']);
        return parent::run();
    }

    protected function getFieldNameFile()
    {
        return static::PREFIX_NAME_FIELD . $this->nameTypeFile;
    }

    protected function getFieldOriginNameFile()
    {
        return static::PREFIX_ORIGIN_NAME_FIELD . $this->nameTypeFile;
    }
}