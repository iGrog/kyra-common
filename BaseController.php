<?php

    namespace kyra\common;

    use yii\web\Controller;

    class BaseController extends Controller
    {
        public $layout = 'main';
        public $pageTitle;
        public $headerTitle;
        public $breadcrumbs;
        public $title;
        public $pageImage;
        public $keywords;
        public $description;
        public $slides = [];
        public $styleClass;
    }