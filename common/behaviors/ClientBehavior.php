<?php

namespace common\behaviors;

use common\events\SendMailEvent;
use common\models\Invoice;
use yii\db\Query;
use common\models\Setting;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ClientBehavior extends \yii\base\Behavior {

    public $fromName = "Vinagex";
    public $fromAddress = "giataivuon@gmail.com";
    public $result = '';
    public $_setting;

    public function events() {
        return [
            Invoice::EVENT_SEND_MAIL => [$this, 'sendMail']
        ];
    }

    public function init() {
        parent::init();
        $this->_setting = Setting::find()->where(['key' => 'config'])->one();
    }

    public function sendMail(SendMailEvent $event) {
//        $setting = (object) (new Query)->from('setting')->where(['key' => 'config'])->one();
//        $query = (new Query)->from('invoice')->where(['code' => (int) $this->data])->one();
        $setting = $this->_setting;
        \Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => $setting->smtp_host,
            'username' => $setting->smtp_username,
            'password' => trim($setting->smtp_password),
            'port' => $setting->smtp_port,
            'encryption' => $setting->smtp_encryption,
            'streamOptions' => [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]
        ]);
        $send = \Yii::$app->mailer->compose('@common/mail/invoice', ['data' => $event->result['invoice']])
                ->setFrom([$setting->email => $setting->name])
                ->setSubject("Don hang")
                ->setTo($event->fromAddress)
                ->send();
    }

}
