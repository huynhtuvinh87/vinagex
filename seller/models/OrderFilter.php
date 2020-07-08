<?php

namespace seller\models;

use Yii;
use common\models\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\components\Constant;

class OrderFilter extends Model {

    public $keywords;

    public function init() {
        parent::init();
    }

    /**
     * @huynhtuvinh87@gmail.com
     */
    public function rules() {
        return [
            [['keywords'], 'default'],
        ];
    }
/**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'status' => 'Trạng thái',
        ];
    }
    public function status() {
        return[
            Constant::STATUS_ORDER_PENDING => 'Đang xử lý',
            Constant::STATUS_ORDER_SENDING => 'Đang giao hàng',
            Constant::STATUS_ORDER_COMPLETE => 'Đã hoàn thành',
            Constant::STATUS_ORDER_BLOCK => 'Đã huỷ'
        ];
    }

    /**
     * @huynhtuvinh87@gmail.com
     * Filter search
     */
    public function fillter($params) {
        $query = Order::find();
        if (!empty($params['keywords'])){
            $query->andWhere(['code'=>(int)$params['keywords']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);

        return $dataProvider;
    }

}
