<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php'
);
return [
    'id' => 'app-cdn',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'cdn\controllers',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is
            //required by cookie validation
            'csrfParam' => '_csrf-cdn',
            'cookieValidationKey' => 'ymoaYrebZHa8gURuolioHGlK8fLXCKjO123456789',
        ],
         'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
     
    ],
    'params' => $params,
];
