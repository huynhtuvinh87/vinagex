<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php'
);
return [
    'id' => 'app-company',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'company\controllers',
    'components' => [
        'i18n' => [
            'translations' => [
                'company' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@company/messages',
                ]
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is
            //required by cookie validation
            'csrfParam' => '_csrf-company',
            'cookieValidationKey' => 'ymoaYrebZHa8gURuolioHGlK8fLXCKjOe4123W24E',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-forum', 'httpOnly' => true],
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
                'login' => 'site/login',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
