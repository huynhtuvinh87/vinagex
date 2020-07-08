<?php

namespace seller\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SellerAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function init() {
        parent::init();
        // resetting BootstrapAsset to not load own css filesß
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
//            'css' => ['css/bootstrap.min.css'],
//            'js' => ['js/bootstrap.min.js']
        ];
    }

    public $css = [
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
        'https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.4/datepicker.css',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css',
        'css/summernote.css',
        'css/jquery-ui.css',
        'https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css',
        'css/bootstrap-datetimepicker.min.css',
        'fonts/css/font-awesome.min.css',
        'css/seller.css',
        'css/responsive.css',
    ];
    public $js = [
        'js/jquery-ui.js',
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js',
        'js/summernote.js',
        'https://rawgit.com/tuupola/jquery_lazyload/2.x/lazyload.js',
        'https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js',
        'js/jquery-input-file-text.js',
        'js/bootstrap-datetimepicker.min.js',
        'js/jquery.countdown.min.js',
        'js/cleave.js',
        'js/common.js',
        'js/readmore.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
