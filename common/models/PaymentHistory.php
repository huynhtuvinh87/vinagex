<?php

namespace common\models;

use yii\mongodb\ActiveRecord;
use common\models\User;

class PaymentHistory extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'payment_history';
    }

    public function attributes() {
        return [
            '_id',
            'order',
            'owner',
            'category',
            'product_type',
            'province',
            'product',
            'quantity',
            'price',
            'date'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getAuth() {
        $model = User::findOne(['_id' => $this->order['actor']]);
        if ($model->active && ($model->active['address'] == '1') && ($model->active['phone'] == '1') && ($model->active['image_verification'] == '1')) {
            return TRUE;
        }
        return FALSE;
    }

}
