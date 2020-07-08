<?php

namespace common\models;

use yii\mongodb\ActiveRecord;
use common\models\Product;

class Comment extends ActiveRecord {

    const STATUS_NOACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_SPAM = 3;
    const STATUS_TRASH = 4;

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'comment';
    }

    public function attributes() {
        return [
            '_id',
            'ip',
            'actor_id',
            'name',
            'email',
            'product',
            'content',
            'sex',
            'answers',
            'count_answer',
            'status',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'email', 'content', 'sex'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'product_id' => 'Sản phẩm',
            'status' => 'Trạng thái',
            'name' => 'Họ tên',
            'email' => 'Email',
            'content' => 'Bình luận',
            'answers' => 'Trả lời'
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

    public function getId() {
        return (string) $this->_id;
    }

    public static function active() {
        $query = self::find();
        return $query->where(['status' => self::STATUS_ACTIVE]);
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function status() {
        return[
            0 => 'Chưa duyệt',
            self::STATUS_ACTIVE => 'Duyệt',
            self::STATUS_NOACTIVE => 'Không duyệt'
        ];
    }

}
