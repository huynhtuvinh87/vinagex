<?php

namespace common\models;

use yii\base\Model;
use common\models\Setting;

/**
 * Sendmail
 */
class SendMail extends Model {

    public $_setting;

    public function init() {
        parent::init();
        $this->_setting = Setting::findOne(['key' => 'config']);
    }

    public static function send($layout, $data, $from, $subject, $to) {
        $setting = Setting::findOne(['key' => 'config']);
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
        $send = \Yii::$app->mailer->compose($layout, ['data' => $data])
                ->setFrom($from)
                ->setSubject($subject)
                ->setTo($to)
                ->send();
        return TRUE;
    }

}
