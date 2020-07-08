<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use common\components\Constant;


class Notification extends ActiveRecord {


    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'notification';
    }

    public function attributes() {
        return [
            '_id',
            'type',
            'owner',
            'content',
            'url',
            'status',
            'created_at',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }
}
