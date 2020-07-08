<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\mongodb\Query;
use common\components\Constant;

class Review extends ActiveRecord {

    const STATUS_ACTIVE = 2;
    const STATUS_NOACTIVE = 3;

    public $product_id;

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'review';
    }

    public function init(){
        parent::init();
    }

    public function attributes() {
        return [
            '_id',
            'ip',
            'actor',
            'product',
            'content',
            'star',
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
            [['content'], 'required', 'message' => ''],
            [['star'], 'integer'],
            ['product', 'default']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'product_id' => 'Sản phẩm',
            'status' => 'Trạng thái',
            'rating' => 'Rating',
            'star' => 'Sao',
            'content' => 'Nội dung',
            'created_at' => 'Ngày đánh giá'
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

    public static function getQuery() {
        $query = self::find();
        return $query->where(['status' => self::STATUS_ACTIVE]);
    }

    public function status() {
        return[
            1 => 'Chưa duyệt',
            self::STATUS_ACTIVE => 'Duyệt',
            self::STATUS_NOACTIVE => 'Không duyệt'
        ];
    }

    public function getVerified() {
        return (new Query)->from('order')->where(['buyer.id' => $this->actor['id'], 'product.id' => $this->product['id'], 'status' => Constant::STATUS_ORDER_FINISH])->count();
    }

    public function getUser(){
        return (new Query)->from('user')->where(['_id'=>$this->actor['id']])->one();
    }

}
