<?php

namespace common\models;

use yii\mongodb\ActiveRecord;

class Statics extends ActiveRecord {

    public static function collectionName() {
        return 'statics';
    }

    public function attributes() {
        return [
            '_id',
            'owner',
            'product_type',
            'quantity',
            'price',
            'unit'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
