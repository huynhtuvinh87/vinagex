<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use common\components\Constant;
use yii\mongodb\Query;

class Order extends ActiveRecord {

    public $province_id;
    public $_setting;
    public $_province;

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'order';
    }

    public function attributes() {
        return [
            '_id',
            'invoice',
            'actor',
            'name',
            'province',
            'district',
            'ward',
            'address',
            'phone',
            'email',
            'code',
            'total',
            'payments',
            'status',
            'product',
            'buyer',
            'date_begin',
            'date_end',
            'transport',
            'content',
            'invoice_code',
            'created_at',
            'updated_at',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function init() {
        $this->_setting = Setting::findOne(['key' => 'config']);

        if (!\Yii::$app->user->isGuest) {
            $this->name = Yii::$app->user->identity->fullname;
            $this->actor = Yii::$app->user->id;
            $this->email = Yii::$app->user->identity->email;
            $this->phone = Yii::$app->user->identity->phone;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'address', 'phone', 'ward', 'province', 'district'], 'required', 'message' => ''],
            [['phone'], 'integer', 'message' => 'Điện thoại không hợp lệ'],
            [['phone', 'payments'], 'integer'],
            ['phone', 'string', 'min' => 10, 'max' => 11, 'tooShort' => 'Số điện thoại phải từ 10 đến 11 số', 'tooLong' => 'Số điện thoại phải từ 10 đến 11 số!'],
            ['email', 'email'],
            ['status', 'default', 'value' => Constant::STATUS_ORDER_PENDING]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => 'Họ và tên',
            'phone' => 'Điện thoại',
            'address' => 'Địa chỉ (Số nhà, đường)',
            'province' => 'Tỉnh thành',
            'district' => 'Quận/Huyện',
            'ward' => 'Phường/Xã',
            'note' => 'Ghi chú',
            'code' => 'Mã đơn hàng',
            'total' => 'Tổng tiền',
            'status' => 'Trạng thái',
            'delivery_date' => 'Ngày giao hàng',
            'time' => 'Thời gian dự kiến đến',
            'note' => 'Ghi chú',
            'created_at' => 'Ngày mua'
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

//    public function afterSave($insert, $changedAttributes) {
//        parent::afterSave($insert, $changedAttributes);
//        $conlection = Yii::$app->mongodb->getCollection('product');
//        $products = [];
//        $cart = \Yii::$app->cart->getItems();
//        if (!empty($cart)) {
//            $owner = $status = [];
//            foreach ($cart as $key => $value) {
//                $id = Yii::$app->mongodb->getCollection('product_order')->insert([
//                    'order' => [
//                        'id' => $this->id,
//                        'actor' => $this->actor,
//                        'code' => $this->code,
//                        'name' => $this->name,
//                        'phone' => $this->phone,
//                        'email' => $this->email,
//                        'address' => $this->address,
//                        'ward' => $this->ward,
//                        'district' => $this->district,
//                        'province' => $this->province
//                    ],
//                    'location' => [
//                        'from' => $value->getProduct()['owner']['province']['id'],
//                        'to' => $this->province_id
//                    ],
//                    'owner' => $value->getProduct()['owner'],
//                    'product' => [
//                        'id' => $value->getProduct()['id'],
//                        'type' => $value->getType() > 0 ? 1 : 0,
//                        'title' => $value->getProduct()['title'],
//                        'slug' => $value->getProduct()['slug'],
//                        'image' => $value->getProduct()['image'],
//                        'unit' => $value->getProduct()['unit'],
//                        'price' => $value->getPrice(),
//                        'quantity' => $value->getQuantity()
//                    ],
//                    'status' => Constant::STATUS_ORDER_PENDING,
//                    'datetime' => date('d/m/Y', time()),
//                    'public' => 1,
//                ]);
//                $owner[] = $value->getProduct()['owner']['id'];
//            }
//            if ($this->email) {
//                $order = [
//                    'id' => $this->id,
//                    'code' => $this->code,
//                    'name' => $this->name,
//                    'phone' => $this->phone,
//                    'address' => $this->address,
//                    'email' => $this->email,
//                    'ward' => $this->ward,
//                    'district' => $this->district,
//                    'province' => $this->province,
//                    'total' => $this->total,
//                    'payments' => Constant::CHECKOUT_PAYMENTS[$this->payments]
//                ];
//                $query = (new Query)->from('product_order')->where(['order.id' => $this->id])->all();
//                return SendMail::send('@common/mail/order', ['order' => $order, 'product' => $query], [$this->_setting->email => $this->_setting->name], ' Đơn hàng #' . $order['code'], $order['email']);
//            }
//            return TRUE;
//        }
//        return FALSE;
//    }

    public function code($code) {
        $model = Order::find()->where(['code' => $code])->one();
        if ($model) {
            $this->code(rand(100000000, 999999999));
        }
        return $code;
    }

    public function countStatus($status){
        return (new Query)->from('order')->where(['owner.id' => \Yii::$app->user->id,'status' => (int)$status])->count();
    }

    public function getReviewBuyer(){
        return (new Query)->from('review_buyer')->where(['buyer.id' => $this->buyer['id']])->one();
    }
}
