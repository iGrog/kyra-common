<?php

    namespace kyra\common;

    use yii\web\AssetBundle;

    class NotifyPopupAsset extends AssetBundle
    {
        public $sourcePath = '@vendor/kyra/common/assets';
        public $js = [
            'notify-custom.min.js',
        ];
        public $css = [
        ];
        public $depends = [
            'yii\web\JqueryAsset',
        ];
    }