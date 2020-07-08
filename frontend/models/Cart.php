<?php

namespace frontend\models;

use Yii;
use common\models\Product;

class Cart extends \yii\mongodb\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'cart';
    }

    public function attributes() {
        return [
            '_id',
            'product_id',
            'user_id',
            'quantity'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public static function getUser() {
        $query = self::find();
        return $query->where(['actor' => Yii::$app->user->id]);
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['_id' => 'product_id']);
    }

    public function getPrice() {
        $product = Product::findOne($this->product_id);
        if ($this->kind > 0) {
            if (!empty($product->classify[$this->kind - 1]['frame'])) {
                foreach ($product->classify[$this->kind - 1]['frame'] as $value) {
                    if ($this->quantity >= (int) $value['quantity_min'] && $this->quantity <= (int) $value['quantity_max']){
                        return $value['price'];
                    }
                }
            } else {
                return $product->classify[$this->kind - 1]['price'];
            }
        } else {

            if (!empty($product->approx)) {
                foreach ($product->approx as $value) {
                    if ($this->quantity >= $value['quantity_min'] && $this->quantity <= $value['quantity_max']) {
                        return $value['price'];
                    }
                }
            } else {
                return $product->price['min'];
            }
        }
    }

}
