<div class="header-image-widget">
    <img src="<?=$this->context->image; ?>" id="<?=$this->context->imageID; ?>" style="max-height: 150px; min-height: 150px; "/>
    <input type="hidden" name="<?=$fName; ?>" id="<?=$fID; ?>" value="<?=$fValue; ?>" />

</div>


<?php

    $addParams = \yii\helpers\Json::encode($this->context->addParams);

$script = <<<SCRIPT
$('#{$this->context->imageID}').imgLoader({ url: '{$this->context->uploadPath}',
iidField : '{$this->context->fieldIID}',
urlField : '{$this->context->fieldImageUrl}',
addParams: $addParams,
postField: '{$this->context->postField}', success: function (json)
{
    if(json.data && json.data.{$this->context->fieldIID}) $('#{$fID}').val(json.data.{$this->context->fieldIID});
}});
SCRIPT;

$this->registerJS($script);
