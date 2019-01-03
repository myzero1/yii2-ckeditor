<?php

namespace myzero1\ckeditor;

use yii\web\AssetBundle;

/**
 * Class CKEditorWidgetAsset
 * @package myzero1\ckeditor
 */
class CKEditorWidgetAsset extends AssetBundle
{
    public $sourcePath = '@myzero1/ckeditor/assets';
    public $js = [
        'ckeditor.widget.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'myzero1\ckeditor\CKEditorAsset',
    ];
}
