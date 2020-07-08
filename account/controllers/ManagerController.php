<?php

namespace account\controllers;

use yii\web\Controller;

class ManagerController extends Controller
{

    public function init()
    {
        parent::init();
        \Yii::$app->mailer->setTransport([
            'class'      => 'Swift_SmtpTransport',
            'host'       => 'smtp.gmail.com',
            'username'   => 'huynhtuvinh87@gmail.com',
            'password'   => 'medcThjoiFj-GDni3OhBN3Zmls7jfxhu',
            'port'       => '587',
            'encryption' => 'tls'
        ]);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    protected function sendmailActive($data)
    {
        $send = \Yii::$app->mailer->compose('active', ['data' => $data])
                ->setFrom(['huynhtuvinh87@gmail.com' => 'Support'])
                ->setSubject('Xác nhận tài khoản')
                ->setTo($data->email)
                ->send();
    }

}
