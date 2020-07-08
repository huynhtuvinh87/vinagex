<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;

class Province extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'province';
    }

    public function attributes() {
        return [
            '_id',
            'name',
            'key',
            'type',
            'order'
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

}
