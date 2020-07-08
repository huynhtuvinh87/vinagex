<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'vi',
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'bootstrap' => [
        'log',
        [
            'class' => 'common\components\LanguageSelector',
            'supportedLanguages' => ['vi', 'en'],
        ]
    ],
    'language' => 'vi',
    'components' => [
        'mongodb1' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://45.77.253.47:27017/transport',
            'options' => [
                "username" => "vinagex",
                "password" => "vng.c0m"
            ]
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://45.77.253.47:27017/giataivuon',
            'options' => [
                "username" => "giataivuon",
                "password" => "gtv.c0m"
            ]
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0
        ],
        'log' => [
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'exportInterval' => 1,
                ],
            ],
        ],
        'sendmail' => [
            'class' => 'common\components\SendMail',
        ],
        'cache' => [
            'class' => 'yii\mongodb\Cache',
            'db' => 'mongodb',
            'cacheCollection' => 'cache',
        ],
        'i18n' => [
            'translations' => [
                'common' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'static' => [
                    'class' => 'yii\mongodb\i18n\MongoDbMessageSource',
                    'collection' => 'translation_static'
                ],
                'data' => [
                    'class' => 'yii\mongodb\i18n\MongoDbMessageSource',
                    'collection' => 'translation_data'
                ],
                'product' => [
                    'class' => 'yii\mongodb\i18n\MongoDbMessageSource',
                    'collection' => 'translation_product'
                ],
                'user' => [
                    'class' => 'yii\mongodb\i18n\MongoDbMessageSource',
                    'collection' => 'translation_user'
                ],
            ],
        ],
        'session' => [
            'name' => '_giataivuon',
            'class' => 'yii\mongodb\Session',
            'sessionCollection' => 'session',
            'timeout' => 2 * 24 * 60 * 60,
            'cookieParams' => [
                'path' => '/',
                'domain' => ".vinagex.com",
            ],
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => false,
            'csrfParam' => '_csrf-vinagex',
            'cookieValidationKey' => 'ymoaYrebZHa8gURuolioHGlK8fLXCKjO123456',
            'csrfCookie' => [
                'name' => '_csrf',
                'path' => '/',
                'domain' => ".vinagex.com",
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'path' => '/',
                'domain' => ".vinagex.com",
            ],
        ],
        'setting' => [
            'class' => 'common\components\SettingComponent'
        ],
        'roletype' => [
            'class' => 'common\components\RoleType'
        ],
    ],
];
