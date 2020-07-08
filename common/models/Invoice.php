<?php

namespace common\models;

use Yii;
use yii\mongodb\ActiveRecord;
use common\components\Constant;

class Invoice extends ActiveRecord {

    const EVENT_SEND_MAIL = 'sendMailEvent';

    public $province_id;
    public $_setting;
    public $_province;

    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'invoice';
    }

    public function attributes() {
        return [
            '_id',
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
            'status',
            'product',
            'created_at',
            'updated_at',
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function init() {
        $this->_setting = Setting::findOne(['key' => 'config']);
        $this->name = Yii::$app->user->identity->fullname;
        $this->actor = Yii::$app->user->id;
        $this->email = Yii::$app->user->identity->email;
        $this->phone = Yii::$app->user->identity->phone;
        if (!empty(Yii::$app->user->identity->province['id'])) {
            $this->province = Yii::$app->user->identity->province['id'];
            $this->district = Yii::$app->user->identity->district['id'];
            $this->ward = Yii::$app->user->identity->ward['id'];
        }
        $this->address = Yii::$app->user->identity->address;
//        $this->on(self::EVENT_SEND_MAIL, [$this, 'sendMail']);
    }

//    public function sendMail($event) {
//        echo 'mail sent to admin';
//        // you code 
//    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'address', 'phone', 'ward', 'province', 'district'], 'required', 'message' => ''],
            [['phone'], 'integer', 'message' => 'Điện thoại không hợp lệ'],
            [['phone'], 'integer'],
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
            Constant::STATUS_ORDER_FINISH => 'Thành công',
            Constant::STATUS_ORDER_BLOCK => 'Đã huỷ'
        ];
    }

    public function behaviors() {
        return [
            ['class' => \common\behaviors\ClientBehavior::className(),
                'fromName' => 'Vinagex',
                'fromAddress' => 'giataivuon@gmail.com',
                'result' => NULL]
        ];
    }

    public function code($code) {
        $model = Invoice::find()->where(['code' => $code])->one();
        if ($model) {
            $this->code(rand(100000000, 999999999));
        }
        return $code;
    }

}
