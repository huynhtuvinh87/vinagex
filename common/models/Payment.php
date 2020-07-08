<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;

/**
 * 
 */
class Payment extends ActiveRecord {

    public static function collectionName() {
        return 'payment';
    }

    public function attributes() {
        return [
            '_id',
            'bank',
            'owner',
        ];
    }

}

?>