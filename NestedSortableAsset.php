<?php

    namespace kyra\common;

    use yii\web\AssetBundle;

    class NestedSortableAsset extends AssetBundle
    {
        public $sourcePath = '@vendor/kyra/common/assets';
        public $js = [
            'jquery-ui-1.10.3.custom.min.js',
            'nestedSortable.js',
        ];
        public $css = [
        ];
        public $depends = [
            'yii\web\JqueryAsset',
            'kyra\common\NotifyPopupAsset',
        ];
    }