<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fonts/css/font-awesome.min.css',
        'css/animate.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css',
        'css/icon.css',
        'https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.4/datepicker.css',
        'css/custom.css',
        'css/summernote.css',
        'lightbox/lightbox.css',
    ];
    public $js = [
        'https://ajax.googleapis.com/ajax/libs/angularjs/1.2.9/angular.min.js',
        'js/jquery-ui.min.js',
        'js/moment.min.js',
        'js/tinymce/tinymce.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js',
        'js/custom.js',
        'js/article.js',
        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js',
        'js/summernote.js',
        'lightbox/lightbox.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
