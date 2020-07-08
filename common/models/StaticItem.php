<?php

namespace common\models;

use yii\mongodb\ActiveRecord;

class StaticItem extends ActiveRecord {

    public static function collectionName() {
        return 'static_item';
    }

    public function attributes() {
        return [
            '_id',
            'static_id',
            'unit',
            'province',
            'quantity',
            'date'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['static_id', 'string']
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
