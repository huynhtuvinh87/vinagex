<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php'
);
return [
    'id' => 'app-message',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'message\controllers',
    'components' => [
        's3' => [
            'class' => 'common\components\S3',
            'key' => 'AKIAIM7TZ36UCAARNVDQ',
            'secret' => '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',
            'bucket' => 'giataivuon',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is
            //required by cookie validation
            'csrfParam' => '_csrf-message',
            'cookieValidationKey' => 'ymoaYrebZHa8gURuolioHGlK8fLXCKjO123456789',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login'],
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
                'message/<id:\w+>' => 'site/message',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => FALSE,
        ],
        'city' => [
            'class' => 'common\components\City',
        ],
        'helper' => [
            'class' => 'message\components\Helper',
        ],
    ],
    'params' => $params,
];
