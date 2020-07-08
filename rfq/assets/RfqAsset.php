<?php

namespace rfq\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class RfqAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $cssOptions = ['version' => '1.0'];

    public function init() {
        parent::init();
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => ['css/bootstrap.min.css'],
            'js' => ['js/bootstrap.min.js']
        ];
    }

    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css',
        'https://vinagex.com/template/style.css',
        'css/languages.min.css',
        'css/summernote.css',
        'css/jquery.datetimepicker.css',
        'lightbox/lightbox.css',
        'slick/slick.css',
        'css/style.css',
        'css/responsive.css'
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js',
        'js/summernote.js',
        'js/jquery.datetimepicker.full.js',
        'js/cleave.js',
        'js/lazyload.js',
        'slick/slick.min.js',
        'lightbox/lightbox.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
