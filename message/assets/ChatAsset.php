<?php

namespace seller\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ChatAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function init() {
        parent::init();
        // resetting BootstrapAsset to not load own css filesß
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => ['css/bootstrap.min.css'],
            'js' => ['js/bootstrap.min.js']
        ];
    }

    public $css = [
        'css/jquery.scrollbar.css',
        'lightbox/lightbox.css',
        'slick/slick.css',
    ];
    public $js = [
        'js/jquery.scrollbar.min.js',
        'slick/slick.min.js',
        'lightbox/lightbox.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
