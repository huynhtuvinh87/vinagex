<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;

class Message extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function conllectionName() {
        return 'message';
    }

    public function init() {
        
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            '_id',
            'receive',
            'avatar',
            'last_msg',
            'last_msg_count',
            'last_msg_time',
            'sender_last_msg',
            'sender',
            'product',
            'order',
            'status',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function attributeLabels() {
        return [
            // '_id',
            'actor' => 'Người trả lời',
            'avatar' => 'Ảnh đại diện',
            'last_msg' => 'Tin nhắn cuối cùng',
            'last_msg_time' => 'Thời gian nhắn tin',
            'owner' => 'Người gửi',
            'product' => 'Sản phẩm',
                //'status',
        ];
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ]);
    }

}
