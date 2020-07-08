<?php

namespace frontend\components;

use yii\base\BaseObject;
use yii\mongodb\Query;
use yii\base\Component;

class SendMail extends Component {

    const INVOICE = 'invoice';

    public $_setting;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->_setting = (object) (new Query)->from('setting')->where(['key' => 'config'])->one();
    }

    function invoice($code) {
        $query = (new Query)->from('invoice')->where(['code' => (int) $code])->one();
        return $this->send('@frontend/mail/invoice', ['data' => $query], [$this->_setting->email => $this->_setting->name], ' Đơn hàng #' . $query['code'], $query['email']);
    }

    public function send($layout, $data, $from, $subject, $to) {
        \Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => $this->_setting->smtp_host,
            'username' => $this->_setting->smtp_username,
            'password' => trim($this->_setting->smtp_password),
            'port' => $this->_setting->smtp_port,
            'encryption' => $this->_setting->smtp_encryption,
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
