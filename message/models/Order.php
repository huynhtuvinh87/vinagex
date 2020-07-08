<?php

namespace message\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\Constant;
use common\models\Setting;
use common\models\ProductProvince;
use common\models\ProductOrder;
use common\models\SellerOrder;
use common\models\SendMail;

class Order extends \yii\base\Model {

    const CHECKOUT_GETRATE = 1;
    const CHECKOUT_ORDER = 2;

    public $_setting;
    public $_token;
    public $name;
    public $phone;
    public $email;
    public $note;
    public $quantity;
    public $product_id;
    public $seller_id; 
    public $province_id;
    public $payments;
    public $address;

    /**
     * @inheritdoc
     */
    public function init() {
        $this->_setting = Setting::findOne(['key' => 'config']);
        $this->_token = Yii::$app->session['user'];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'address', 'phone', 'quantity', 'product_province_id'], 'required', 'message' => ''],
            [['phone'], 'integer', 'message' => 'Điện thoại không hợp lệ'],
            [['phone', 'payments'], 'integer'],
            ['phone', 'string', 'min' => 10, 'max' => 11, 'tooShort' => 'Số điện thoại phải từ 10 đến 11 số', 'tooLong' => 'Số điện thoại phải từ 10 đến 11 số!'],
            ['email', 'email'],
            ['note', 'string'],
            [['quantity'], 'integer'],
            ['status', 'default', 'value' => Constant::STATUS_ORDER_CGH]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Họ và tên',
            'phone' => 'Điện thoại',
            'address' => 'Địa chỉ giao hàng',
            'province_id' => 'Tỉnh / thành',
            'note' => 'Ghi chú',
            'code' => 'Mã đơn hàng',
            'total' => 'Tổng tiền',
            'status' => 'Trạng thái',
            'quantity' => 'Số lượng',
            'created_at' => 'Ngày mua'
        ];
    }

    public function checkout() {
        return [
            self::CHECKOUT_ORDER => 'Đặt hàng',
            self::CHECKOUT_GETRATE => 'Nhận báo giá'
        ];
    }

    public function province() {
         $province = (new \yii\mongodb\Query())->from('province')->select(['_id', 'name'])->all();
        $data = [];
        foreach ($province as $value) {
            $data[(string) $value['_id']] = $value['name'];
        }
        return $data;
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

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function save() {
        $product_province = ProductProvince::findOne($this->product_province_id);
        $order = \Yii::$app->db->createCommand()->insert('order', [
                    'code' => $this->code(rand(100000000, 999999999)),
                    'user_id' => $this->_token['user_id'],
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'note' => $this->note,
                    'address' => $this->address,
                    'payments' => $this->payments,
                    'province_id' => $product_province->province_id,
                    'total' => $this->quantity * $product_province->product_original_price,
                    'created_at' => time(),
                    'updated_at' => time(),
                ])->execute();
        $id = \Yii::$app->db->getLastInsertID($order);
        $data = [
            'order_id' => $id,
            'product_id' => $product_province->product_id,
            'quantity' => $this->quantity,
            'price' => $product_province->product_original_price,
            'province_id' => $product_province->province_id,
            'seller_id' => $product_province->user_id
        ];
        $product_order = \Yii::$app->db->createCommand()->insert('product_order', $data)->execute();
        $product_province->quantity_purchased = $product_province->quantity_purchased + $this->quantity;
        if (($product_province->quantity_pending + $this->quantity) >= $product_province->product_minimum_quantity) {
            \Yii::$app->db->createCommand()->insert('seller_order', [
                'code' => $this->code(rand(100000000, 999999999)),
                'seller_id' => $product_province->user_id,
                'product_id' => $product_province->product_id,
                'province_id' => $product_province->province_id,
                'product_province_id' => $this->product_province_id,
                'quantity' => $product_province->quantity_pending + $this->quantity,
                'price' => $product_province->product_original_price,
                'status' => Constant::STATUS_ORDER_CGH,
                'created_at' => time(),
                'updated_at' => time(),
            ])->execute();
            $product_province->quantity_pending = 0;
        } else {
            $product_province->quantity_pending = $product_province->quantity_pending + $this->quantity;
        }
        $product_province->save();
        $query = (new \yii\db\Query());
        $order = $query->select(['order.*'])
                ->from('giataivuon.order')
                ->where(['id' => $id])
                ->one();
        $product = ProductOrder::find()->where(['order_id' => $order['id']])->all();
        if ($order['email']) {
            SendMail::send('order', ['order' => $order, 'product' => $product], [$this->_setting->email => $this->_setting->name], $this->_setting->name . ' #' . $order['code'], $order['email']);
        }
        return $order;
    }

    public function code($code) {
        $model = SellerOrder::find()->where(['code' => $code])->one();
        if ($model) {
            $this->code(rand(100000000, 999999999));
        }
        return $code;
    }

}
