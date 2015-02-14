<?php

    namespace kyra\common;

    use yii\web\AssetBundle;

    class Image2HiddenFieldAsset extends AssetBundle
    {
        public $sourcePath = '@vendor/kyra/common/assets';
        public $js = [
            'imgLoader.js',
        ];
        public $css = [
        ];
        public $depends = [
            'yii\web\JqueryAsset',
        ];
    }