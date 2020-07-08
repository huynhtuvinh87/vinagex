<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php'
);
return [
    'id' => 'app-seller',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'seller\controllers',
    'components' => [
        'i18n' => [
            'translations' => [
                'seller' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                ]
            ],
        ],
        'province' => [
            'class' => 'frontend\storage\ProvinceStorage',
        ],
//        'request' => [
//            'cookieValidationKey' => 'WGwiceX-Fn_VxcBbn32owp9uZc5UZaBA',
//            'csrfParam' => '_csrf-seller',
//        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-seller', 'httpOnly' => true],
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@seller/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => FALSE,
        ],
        'city' => [
            'class' => 'common\components\City',
        ],
    ],
    'params' => $params,
];
