<?php

    namespace kyra\common;

    use yii\helpers\Html;
    use yii\widgets\InputWidget;

    class Image2HiddenField extends InputWidget
    {
        public $uploadPath = '/admin/upload';
        public $imageID = 'img';
        public $image = '';
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
            if(empty($this->image)) $this->image = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
            return $this->render('header_image', ['fName' => $fName, 'fID' => $fID, 'fValue' => $fValue]);
        }
    }