<?php

namespace common\models;

use yii\mongodb\ActiveRecord;

class Wishlist extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'wishlist';
    }

    public function init() {
        parent::init();
    }

    public function attributes() {
        return [
            '_id',
            'user_id',
            'product_id',
            'seller_id',
            'created_at',
            'updated_at'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['_id' => 'product_id']);
    }
    
    public function getSeller() {
        return $this->hasOne(User::className(), ['_id' => 'seller_id']);
    }

}
