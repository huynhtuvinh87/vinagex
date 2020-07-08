<?php

namespace seller\models;

use Yii;
use yii\base\Model;
use common\components\Constant;
use yii\mongodb\Query;

/**
 * Product form
 */
class OrderForm extends Model {

    
    public $reason;
    public $code;
    public $description;
    public $level_satisfaction;
    
    public function init() {
    }

    const OTHER_BLOCK = 0;
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['reason'], 'required', 'message' => ''],
            [['description'], 'default'],
            ['level_satisfaction', 'integer'],
            ['level_satisfaction', 'required'],
        ];
    }


    public function attributeLabels() {
        return [
            'reason' => 'Có vấn đề gì đang xảy ra',
            'description' => 'Nhập lý do',
        ];
    }

    public function block() {
        return[
            1 => 'Khách hàng mua yêu cầu hủy đơn hàng',
            2 => 'Nhà cung cấp hết hàng',
            3 => 'Nhà cung cấp không thể vận chuyển',
            4 => 'Nhà cung cấp chưa nhận được tiền đặt cọc',
            5 => 'Phương thức thanh toán không thuận tiện',
            6 => 'Nhà cung cấp không có người thu hộ tiền',
            7 => 'Nhà cung cấp không tin tưởng khách hàng mua',
            self::OTHER_BLOCK => 'Lý do khác'
        ];
    }

    public function unsuccessful(){
        return[
            1 => 'Không liên lạc được với khách hàng để nhận hàng',
            2 => 'Không vận chuyển đến nơi khách nhận',
            3 => 'Khách không nhận hàng',
            4 => 'Sản phẩm bị hư hỏng trên đường vận chuyển',
            self::OTHER_BLOCK => 'Lý do khác'
        ];
    }

}
