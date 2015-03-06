<?php

    namespace kyra\common;

    use yii\web\AssetBundle;

    class KnockoutAsset extends AssetBundle
    {
        public $sourcePath = '@vendor/kyra/common/assets';
        public $js = [
            'knockout-3.2.0.js',
            'knockout.mapping-latest.js',
            'knockout.reactor.js',
            'jquery-ui-1.10.3.custom.min.js',
            'knockout.sortable.js',
        ];
        public $css = [
        ];
        public $depends = [
            'yii\web\JqueryAsset',
        ];
    }