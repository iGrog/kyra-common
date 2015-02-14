<?php

    namespace kyra\common;

    use yii\helpers\Html;
    use yii\widgets\InputWidget;

    class Image2HiddenField extends InputWidget
    {
        public $uploadPath = '/admin/upload';
        public $imageID = 'img';
        public $image = '/images/default.jpg';
        public $postField = 'Image';
        public $fieldIID = 'IID';
        public $fieldImageUrl = 'preview';
        public $addParams = [];

        public function init()
        {
            Image2HiddenFieldAsset::register(\Yii::$app->view);
        }

        public function run()
        {
            $fName = Html::getInputName($this->model, $this->attribute);
            $fID = Html::getInputId($this->model, $this->attribute);
            $fValue = $this->model[$this->attribute];
            return $this->render('header_image', ['fName' => $fName, 'fID' => $fID, 'fValue' => $fValue]);
        }
    }