<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use common\models\UserInfo;

/**
 * 
 */
class Conversation extends ActiveRecord {

    public static function collectionName() {
        return 'conversation';
    }

    public function attributes() {
        return [
            '_id',
            'actor',
            'avatar',
            'date',
            'fullname',
            'message',
            'owner',
            'product_id'
        ];
    }

    public function attributeLabels() {
        return [
            'message' => 'Tin nhắn cuối cùng',
            'date' => 'Thời gian',
            'owner' => 'Người gửi',
            'actor' => 'Người trả lời'
        ];
    }

    public function actor() {
        return UserInfo::findOne(['owner' => $this->actor]);
    }

    public function owner() {
        return UserInfo::findOne(['owner' => $this->owner]);
    }

}

?>