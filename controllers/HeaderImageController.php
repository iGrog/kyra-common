<?php

    namespace kyra\common\controllers;

    use kyra\params\ParamsManager;
    use Yii;

    class HeaderImageController extends \kyra\common\BaseController
    {
        protected $headerImageActions = [];
        protected $useCustomHeaderImage = false;
        protected $useCustomHeaderKey = false;

        public function beforeAction($action)
        {
            if($this->useCustomHeaderImage)
            {
                $headerImage = $this->GetCustomHeaderImage($action);
                if(!empty($headerImage)) $this->pageImage = $headerImage;
            }
            else if($this->useCustomHeaderKey)
            {
                $m = Yii::$app->getModule('kyra.params');
                $pm = new ParamsManager($m->uploadPathKey, 'o');
                $key = $this->GetCustomHeaderImageKey($action);
                $headerImage = $pm->GetParam($key);
                if(!empty($headerImage)) $this->pageImage = $headerImage;
            }
            else if(array_key_exists($action->id, $this->headerImageActions))
            {
                $m = Yii::$app->getModule('kyra.params');
                $pm = new ParamsManager($m->uploadPathKey, 'o');
                $key = 'HEADER_IMAGE_'.$this->headerImageActions[$action->id];
                $headerImage = $pm->GetParam($key);
                if(!empty($headerImage)) $this->pageImage = $headerImage;
            }
            return true;
        }
    }