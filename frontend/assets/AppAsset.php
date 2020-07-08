<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle {

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
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css',
        'template/css/jquery-ui.css',
        'fonts/css/font-awesome.min.css',
        'template/css/lightbox.css',
        'template/style.css',
        'template/css/languages.min.css'
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js',
        'template/js/jquery-ui.js',
        'template/js/lazyload.js',
        'template/js/jquery-input-file-text.js',
        'template/js/lightbox.min.js',
        'template/js/jquery.scrollbar.js',
        'template/js/owl.carousel.min.js',
        'template/js/swiper.js',
        'template/js/slick.min.js',
        'template/js/jquery.easing-1.3.pack.js',
        'template/js/jquery.countdown.min.js',
        'template/js/jquery.balloon.min.js',
        'template/js/rAF.js',
        'template/js/ResizeSensor.js',
        'template/js/sticky-sidebar.js',
        'template/js/main.js',
        'https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
