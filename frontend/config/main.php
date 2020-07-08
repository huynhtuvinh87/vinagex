<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'i18n' => [
            'translations' => [
                'frontend' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@frontend/messages',
                ]
            ],
        ],
        'province' => [
            'class' => 'frontend\storage\ProvinceStorage',
        ],
        'cart' => [
            'class' => 'common\components\Cart',
            'storageClass' => 'common\storage\DbSessionStorage',
            'calculatorClass' => 'common\components\Calculator',
            'params' => [
                'key' => 'cart',
                'expire' => 604800,
                'productClass' => 'common\models\Product'
            ],
        ],
        'seller' => [
            'class' => 'frontend\storage\SellerItem',
            'userClass' => 'common\models\User'
        ],
        'constant' => 'common\components\Constant',
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
                'ban-hang-cung-vinagex' => 'seller/about',
                'huong-dan-xu-li-don-hang' => 'help/order',
                'huong-dan-dang-san-pham' => 'help/product',
                'san-pham-sap-giao' => 'product/pending',
                'san-pham-da-luu' => 'customer/wishlist',
                'tra-cuu-don-hang' => 'order/tracking',
                'nha-vuon-da-dong-bao-hiem' => 'seller/insurrance',
                'nha-cung-cap-uy-tin' => 'seller/level',
                'nha-vuon/<id>' => 'seller/view',
                'nha-cung-cap/<username>-<id>' => 'seller/view',
                'quan-ly-don-hang' => 'invoice/history',
                'san-pham-yeu-thich' => 'customer/wishlist',
                'nha-vuon-ban-quan-tam' => 'customer/wishlistseller',
                'thong-tin-tai-khoan' => 'user/profile',
                'cap-nhat-thong-tin-san-pham/<slug>-<id>' => 'product/info',
                'category/<category>' => 'product/category',
                'filter' => 'filter/index',
                '<slug>-<id>' => 'product/view',
                'p/<slug>' => 'page/index',
                'nhan-xet/<slug>-<id>' => 'review/view',
                'province/<id>' => 'site/province',
                'message/<id>' => 'message/index',
                '/' => 'site/index',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@frontend/mail',
            'useFileTransport' => FALSE,
        ],
    ],
    'params' => $params,
];
