<?php

namespace common\components;

use yii\base\BaseObject;
use yii\mongodb\Query;

class SendMail extends BaseObject {

    public $_setting;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        $this->_setting = (object) (new Query)->from('setting')->where(['key' => 'config'])->one();
    }

    public function order($order_id, $layout, $title) {
        $query = (new Query)->from('order')->where(['_id' => $order_id])->one();
        return $this->send('@common/mail/' . $layout, $query, [$this->_setting->email => $this->_setting->name], $title, $query['buyer']['email']);
    }

    public function orderSeller($order_id, $layout, $title) {
        $query = (new Query)->from('order')->where(['_id' => $order_id])->one();
        if (!empty($query['owner']['email'])) {
            return $this->send('@common/mail/' . $layout, $query, [$this->_setting->email => $this->_setting->name], $title, $query['owner']['email']);
        }
    }

    public function invoice($code, $title) {
        $query = (new Query)->from('invoice')->where(['code' => (int) $code])->one();
        return $this->send('@common/mail/invoice', $query, [$this->_setting->email => $this->_setting->name], $title, $query['email']);
    }

    public function statusSeller($actor, $layout, $title) {
        $query = (new Query)->from('user')->where(['_id' => $actor])->one();
        if (!empty($query['email'])) {
            return $this->send('@common/mail/' . $layout, $query, [$this->_setting->email => $this->_setting->name], $title, $query['email']);
        }
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
