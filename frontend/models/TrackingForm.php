<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Order;

class TrackingForm extends Model {

    public $email_phone;

    public function rules() {
        return [
            [['email_phone'], 'required', 'message' => '{attribute} ' . Yii::t('frontend', 'không được bỏ trống')],
            ['email_phone', 'validateOrder'],
        ];
    }

    public function attributeLabels() {
        return [
            'email_phone' => Yii::t('frontend', 'Nhập email hoặc số điện thoại'),
        ];
    }

    public function validateOrder($attribute, $params) {
        if (!$this->hasErrors()) {
            $order = $this->getOrder();
            if ($order == 0) {
                $this->addError($attribute, Yii::t('frontend', 'Đơn hàng này không tồn tại.'));
            }
        }
    }

    protected function getOrder() {
        if ($this->_order === null) {
            $this->_order = Order::find()->where(['email' => $this->email_phone, 'phone' => $this->email_phone])->count();
        }

        return $this->_order;
    }

}
