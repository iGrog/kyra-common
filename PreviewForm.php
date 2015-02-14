<?php

    namespace kyra\common;

    use yii\base\InvalidCallException;
    use yii\helpers\Html;
    use yii\helpers\Json;
    use yii\helpers\Url;
    use yii\widgets\ActiveFormAsset;

    class PreviewForm extends \yii\widgets\ActiveForm
    {
        public $previewUrl = '';
        public $previewButton = 'preview';


        public function run()
        {
            if (!empty($this->_fields)) {
                throw new InvalidCallException('Each beginField() should have a matching endField() call.');
            }

            $id = $this->options['id'];
            $options = Json::encode($this->getClientOptions());
            $attributes = Json::encode($this->attributes);
            $view = $this->getView();
            ActiveFormAsset::register($view);
            $view->registerJs("jQuery('#$id').yiiActiveForm($attributes, $options);");
            $previewUrl = Url::to($this->previewUrl);

            $previewJS = <<<JS

            var elems = $('button[type="submit"]', '#$id');
            elems.on('click', function(event)
            {
                event.preventDefault();
                var elem = $(event.currentTarget);
                var isPreview = elem.attr('id') == '{$this->previewButton}';
                var form = $('#$id');
                form.removeAttr('target');
                form.attr('action', '{$this->action}');
                if(isPreview)
                {
                    form.attr('target', '_blank');
                    form.attr('action', '$previewUrl');
                }
                form.submit();
            });
JS;

            $view->registerJs($previewJS);
            echo Html::endForm();
        }

    }