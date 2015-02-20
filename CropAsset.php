<?php

    namespace kyra\common;

    use yii\web\AssetBundle;

    class CropAsset extends AssetBundle
    {
        public $sourcePath = '@vendor/kyra/common/assets';
        public $js = [
            'cropper.min.js',
        ];
        public $css = [
            'cropper.min.css',
        ];
        public $depends = [
            'yii\web\JqueryAsset',
        ];
    }