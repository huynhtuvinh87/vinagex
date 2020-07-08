<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;

class SellerOrder extends ActiveRecord {

    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELIVERY = 3;
    const STATUS_SUCCESS = 4;

    public $time;

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'order';
    }

    public function attributes() {
        return [
            '_id',
            'code',
            'product',
            'owner',
            'quantity',
            'delivery_date',
            'province',
            'price',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        $rule = [];
        if ($this->id) {
            $rule = [['delivery_date', 'time'], 'required'];
        }
        return [$rule];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'product' => 'Tên sản phẩm',
            'quantity' => 'Số lượng',
            'price' => 'Đơn giá',
            'province' => 'Nơi giao hàng',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày mua',
            'delivery_date' => 'Ngày giao hàng',
            'time' => 'Thời gian'
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
