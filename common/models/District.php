<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;

class District extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'district';
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'slug',
            'type',
            'province_id',
            'ward'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
