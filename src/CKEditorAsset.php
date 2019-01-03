<?php

namespace myzero1\ckeditor;

use yii\web\AssetBundle;

/**
 * Class CKEditorAsset
 * @package myzero1\ckeditor
 */
class CKEditorAsset extends AssetBundle
{
    public $sourcePath = '@vendor/ckeditor/ckeditor';
    public $js = [
        'ckeditor.js',
        'adapters/jquery.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $publishOptions = [
        'except' => ['samples/'],
    ];
}
