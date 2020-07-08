<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class FrontendController extends Controller {

    public function init() {
        parent::init();
        \Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'huynhtuvinh87@gmail.com',
            'password' => 'medcThjoiFj-GDni3OhBN3Zmls7jfxhu',
            'port' => '587',
            'encryption' => 'tls'
        ]);
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionUrllog() {
        $log = (new Query())->from('log')->where(['ip' => Yii::$app->getRequest()->getUserIP(), 'type' => 'url'])->one();
        if (!empty($log)) {
            Yii::$app->mongodb->getCollection('log')->update(['_id' => (string) $log['_id']], ['$set' => ["url" => $url]]);
        } else {
            Yii::$app->mongodb->getCollection('log')->insert([
                'type' => 'url',
                'goBack' => $url,
            ]);
        }
    }

    protected function sendmailActive($data) {
        $send = \Yii::$app->mailer->compose('active', ['data' => $data])
                ->setFrom(['huynhtuvinh87@gmail.com' => 'Support'])
                ->setSubject(Yii::t('frontend', 'Xác nhận tài khoản'))
                ->setTo($data->email)
                ->send();
    }

}
