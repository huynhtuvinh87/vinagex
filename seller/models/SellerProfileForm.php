<?php

namespace seller\models;

use Yii;
use common\components\Constant;
use yii\mongodb\Query;
use common\models\Setting;
use common\models\Certification;
use common\models\User;

/**
 * ProfileForm
 */
class SellerProfileForm extends \yii\base\Model {

    public $_user;
    public $fullname;
    public $garden_name;
    public $address;
    public $about;
    public $email;
    public $phone;
    public $province_id;
    public $district;
    public $ward;
    public $images;
    public $certificate;
    public $trademark;
    public $category;
    public $output_provided;
    public $output_provided_unit;
    public $acreage;
    public $acreage_unit;
    public $lat;
    public $long;
    public $certificate_img;
    public $active;
    public $_setting;
    public $_certification;
    public $_seller_certification = [];
    public $field;

    public function init() {
        $this->_setting = Setting::findOne(['key' => 'config']);
        $this->_certification = Certification::find()->all();
        $this->_user = User::findOne(Yii::$app->user->id);
        if (!empty($this->_user->category)) {
            foreach ($this->_user->category as $key => $value) {
                $this->category[] = $value['id'];
            }
        }
        if (!empty($this->_user->certificate)) {
            foreach ($this->_user->certificate as $value) {
                $this->certificate[$value['id']] = [
                    'id' => $value['id'],
                    'image' => $value['image'],
                    'date_begin' => $value['date_begin'],
                    'date_end' => $value['date_end'],
                    'active' => $value['active']
                ];
            }
        }
        $this->active = $this->_user->active;
        $this->phone = $this->_user->phone;
        if (!empty($this->_user->garden_name)) {
            if (!empty($this->_user->images)) {
                $this->images = $this->_user->images;
            }
            $this->fullname = $this->_user->fullname;
            $this->about = $this->_user->about;
            $this->address = $this->_user->address;
            $this->email = $this->_user->email;
            $this->garden_name = $this->_user->garden_name;
            $this->trademark = $this->_user->trademark;
            $this->output_provided = $this->_user->output_provided;
            $this->acreage = $this->_user->acreage;
            $this->output_provided_unit = $this->_user->output_provided_unit;
            $this->acreage_unit = $this->_user->acreage_unit;
            $this->province_id = $this->_user->province['id'];
            $this->lat = $this->_user->lat;
            $this->long = $this->_user->long;
            $this->district = $this->_user->district['id'];
            $this->ward = $this->_user->ward['id'];
        } else {
            $this->fullname = Yii::$app->user->identity->fullname;
            $this->phone = Yii::$app->user->identity->phone;
            $this->email = Yii::$app->user->identity->email;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['fullname', 'about', 'address', 'garden_name', 'category', 'output_provided', 'acreage', 'phone', 'district', 'ward', 'category', 'email'], 'required', 'message' => '{attribute} không được rỗng.'],
            ['phone', 'integer'],
            ['phone', 'string', 'min' => 9, 'max' => 12, 'tooShort' => 'Số điện thoại phải từ 9 đến 11 số', 'tooLong' => 'Số điện thoại phải từ 9  đến 11 số!'],
            ['phone', 'validatePhone'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            ['fullname', 'filter', 'filter' => 'trim'],
            [['province_id'], 'string'],
            [['certificate', 'images', 'output_provided_unit', 'acreage_unit'], 'default'],
            [['lat', 'long', 'trademark'], 'string'],
            ['certificate', function ($attribute, $params) {
                    if (!empty($_POST['SellerProfileForm']['certificate'])) {
                        foreach ($this->certificate as $k => $value) {
                            if (($_POST['certificate_img'][$value] == "") or ( $_POST['certificate_date_begin'][$value] == "") or ( $_POST['certificate_date_end'][$value] == "")) {
                                $this->addError('certificate_img', "Bạn cập nhật giấy chứng nhận chưa chính xác");
                            }
                            $date_begin = strtotime(\Yii::$app->formatter->asDatetime(str_replace('/', '-', $_POST['certificate_date_begin'][$value]), "php:Y-m-d"));
                            $date_end = (\Yii::$app->formatter->asDatetime(str_replace('/', '-', $_POST['certificate_date_end'][$value]), "php:Y-m-d"));
                            if (($date_end <= $date_begin) or ( $date_end <= ($date_end + 31536000))) {
                                $this->addError('certificate_img', 'Ngày cấp, ngày hết hạn giấy chứng nhận không hợp lý');
                            }
                        }
                    }
                }],
        ];
    }

    public function validatePhone($attribute, $params) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['phone' => $this->phone])->one();
            if (!empty($model)) {
                if ($model->id != $this->id)
                    $this->addError($attribute, $this->phone . 'Số điện thoại này đã tồn tại trong hệ thống');
            }
        }
    }

    public function validateEmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['email' => $this->email])->one();
            if (!empty($model)) {
                if ($model->id != $this->id)
                    $this->addError($attribute, 'Email này đã tồn tại trong hệ thống');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'fullname' => 'Tên chủ liên hệ',
            'garden_name' => 'Tên cơ sở',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'phone' => 'Điện thoại',
            'about' => 'Gới thiệu',
            'birthday' => 'Ngày sinh',
            'province_id' => 'Tỉnh/thành',
            'gender' => 'Giới tính',
            'avatar' => 'Hình đại diện',
            'images' => 'Hình ảnh nhà vườn',
            'district' => 'Quận/huyện',
            'ward' => 'Phường/xã',
            'address' => 'Địa chỉ',
            'certificate' => 'Chứng nhận',
            'certificate_document' => 'Hình ảnh chứng nhân',
            'password_new' => 'Mật khẩu mới',
            'password_rep' => 'Xác nhận mật khẩu mới',
            'username' => 'Tên đăng nhập',
            'trademark' => 'Thương hiệu',
            'product_provided' => 'Sản phẩm cung cấp',
            'output_provided' => 'Sản lượng cung cấp',
            'acreage' => 'Quy mô / Diện tích'
        ];
    }

    public function output_provided_unit() {
        return [
            'tấn' => 'tấn',
            'tạ' => 'tạ',
            'kg' => 'kg'
        ];
    }

    public function acreage_unit() {
        return [
            'ha' => 'ha',
            'm2' => 'm2'
        ];
    }

    public function provinceArray($id) {
        return (new Query())->select(['name', '_id'])
                        ->from('province')
                        ->where(['_id' => $id])->orWhere(['key' => $id])->one();
    }

    public function category($id = NULL) {
        $query = new Query();
        $query->select(['parent'])
                ->from('category');
        $rows = $query->all();
        $data = [];

        if (!empty($rows)) {
            foreach ($rows as $key => $value) {
                foreach ($value['parent'] as $val) {
                    if (!empty($id) && $val['id'] == $id) {
                        return $val;
                    }
                    $data[$val['id']] = $val['title'];
                }
            }
        }
        return $data;
    }

    public function changeRfq($data) {
         
        
    }

}
