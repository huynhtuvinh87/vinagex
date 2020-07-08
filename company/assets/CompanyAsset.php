<?php

namespace company\assets;

use yii\web\AssetBundle;

class CompanyAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function init() {
        parent::init();
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => ['css/bootstrap.min.css'],
            'js' => ['js/bootstrap.min.js']
        ];
    }

    public $css = [
        'https://vinagex.com/template/style.css',
        'https://vinagex.com/template/css/languages.min.css',
        'css/style.css',
        'css/responsive.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
