<?php

namespace myzero1\ckeditor;

use yii\web\AssetBundle;

class WidgetAsset extends AssetBundle
{
    public $sourcePath = '@myzero1/ckeditor/assets';
    public $js = [
        'widget.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
