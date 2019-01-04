# CKEditor widget for Yii 2

This extension renders a [CKEditor](http://ckeditor.com/) widget for [Yii framework 2.0](http://www.yiiframework.com).

[![License](https://poser.pugx.org/myzero1/yii2-ckeditor/license)](https://packagist.org/packages/myzero1/yii2-ckeditor)

## Installation

Install extension through [composer](http://getcomposer.org/):

Either run

```
php composer.phar require "myzero1/yii2-ckeditor" "*"
```
or add

```json
"myzero1/yii2-ckeditor" : "*"
```

to the require section of your application's `composer.json` file.


## Config the action for upload

Add the section of your application's `main.json` file, as flowing:

```

return [
    ......
    'controllerNamespace' => 'backend\controllers',
    'controllerMap' => [
        'ckeditor' => [
            'class' => 'myzero1\ckeditor\CKditorController',
            'config' => [
                'imageFieldName' => 'upload',
                'imageMaxSize' => 1024*1024*2, // 2M = 1024*1024*2
                'imageAllowFiles' => ['.jpg', '.jpeg', '.png', '.gif'],
                'imagePathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:8}',
            ],
        ]
    ],
    'bootstrap' => ['log'],
    ......
```

## Usage

The following code in a view file would render a CKEditor widget:

```php
<?= myzero1\ckeditor\CKEditor::widget(['name' => 'attributeName']) ?>
```

Configuring the [CKEditor options](http://docs.ckeditor.com/#!/api/CKEDITOR.config) should be done
using the `clientOptions` attribute:

```php
<?= myzero1\ckeditor\CKEditor::widget([
    'name' => 'attributeName',
    'clientOptions' => [
        'extraPlugins' => 'autogrow,colorbutton,colordialog,iframe,justify,showblocks,preview,image2',
        // 'extraPlugins' => 'autogrow,colorbutton,colordialog,iframe,justify,showblocks,preview,easyimage',
        'removePlugins' => 'resize,image',
        'autoGrow_maxHeight' => 900,
        'stylesSet' => [
            ['name' => 'Subscript', 'element' => 'sub'],
            ['name' => 'Superscript', 'element' => 'sup'],
        ],
    ],
]) ?>
```

If you want to use the CKEditor widget in an ActiveForm, it can be done like this:

```php
<?= $form->field($model, 'attributeName')->widget(myzero1\ckeditor\CKEditor::className()) ?>
```


If you want to use the CKEditor widget in an ActiveForm,and to configuring the CKEditor options, it can be done like this:

```php
<?= $form->field($model, 'attributeName')->widget(myzero1\ckeditor\CKEditor::className(), [
        'clientOptions' => [
            'selectMultiple' => true,
            'filebrowserImageUploadUrl' => '/ckeditor/upload-image',
            'imageUploadUrl' => '/ckeditor/upload-image',
            'extraPlugins' => 'autogrow,colorbutton,colordialog,iframe,justify,showblocks,preview,image2',
            // 'extraPlugins' => 'autogrow,colorbutton,colordialog,iframe,justify,showblocks,image2,preview,easyimage',
            'removePlugins' => 'resize,image',
            'autoGrow_maxHeight' => 900,
            'stylesSet' => [
                ['name' => 'Subscript', 'element' => 'sub'],
                ['name' => 'Superscript', 'element' => 'sup'],
            ],
        ],
    ]) ?>

```