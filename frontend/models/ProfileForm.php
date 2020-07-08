<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\mongodb\Query;
use common\models\Province;
use common\models\District;

class ProfileForm extends Model {

    public $fullname;
    public $email;
    public $phone;
    public $address;
    public $province;
    public $district;
    public $ward;
    public $image_verification;
    public $facebook;
    public $_user;
    public $active;
    public $display;
    public $avatar;

    public function init() {
        parent::init();
        $this->_user = (object) (new Query())->from('user')->where(['_id' => Yii::$app->user->id])->one();
        $this->fullname = \Yii::$app->user->identity->fullname;
        $this->email = \Yii::$app->user->identity->email;
        $this->phone = \Yii::$app->user->identity->phone;
        $this->avatar = \Yii::$app->user->identity->avatar;
        if (!empty($this->_user->active)) {
            $this->active = $this->_user->active;
        }
        if (!empty($this->_user->display)) {
            $this->display = $this->_user->display;
        }
        if (!empty($this->_user->address)) {
            $this->address = $this->_user->address;
        }
        if (!empty($this->_user->facebook)) {
            $this->facebook = $this->_user->facebook;
        }
        if (!empty($this->_user->image_verification)) {
            $this->image_verification = $this->_user->image_verification;
        }
        if (!empty($this->_user->province)) {
            $this->province = $this->_user->province['id'];
            $this->district = $this->_user->district['id'];
            $this->ward = $this->_user->ward['id'];
        }
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['display'], 'default'],
            ['fullname', 'required', 'message' => Yii::t('frontend', 'Họ tên không được bỏ trống')],
            ['address', 'required', 'message' => Yii::t('frontend', 'Địa chỉ không được bỏ trống')],
            ['email', 'email', 'message' => Yii::t('frontend', 'Địa chỉ email không đúng')],
            ['phone', 'required', 'message' => Yii::t('frontend', 'Điện thoại không được bỏ trống')],
            ['province', 'required', 'message' => Yii::t('frontend', 'Tỉnh thành không được bỏ trống')],
            ['district', 'required', 'message' => Yii::t('frontend', 'Quận/huyện không được bỏ trống')],
            ['ward', 'required', 'message' => Yii::t('frontend', 'Quận/huyện không được bỏ trống')],
            ['phone', 'string', 'min' => 9, 'max' => 12, 'tooShort' => Yii::t('frontend', 'Số điện thoại phải từ 9 đến 11 số'), 'tooLong' => Yii::t('frontend', 'Số điện thoại phải từ 9  đến 11 số!')],
            [['facebook'], 'string'],
            ['image_verification', 'default']
        ];
    }

    public function attributeLabels() {
        return [
            'fullname' => Yii::t('frontend', 'Họ và tên'),
            'phone' => Yii::t('frontend', 'Điện thoại'),
            'province' => Yii::t('frontend', 'Tỉnh thành'),
            'district' => Yii::t('frontend', 'Quận/huyện'),
            'ward' => Yii::t('frontend', 'Phường/xã'),
            'address' => Yii::t('frontend', 'Số nhà'),
            'image_verification' => Yii::t('frontend', 'Xác minh địa chỉ'),
            'display' => Yii::t('frontend', 'Công khai')
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save() {
        if (!$this->validate()) {
            return null;
        }
        $province = Province::findOne($this->province);
        $district = District::findOne($this->district);
        $key = array_search($this->ward, array_column($district->ward, 'slug'));
        $ward = $district->ward[$key];
        $data = [
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'facebook' => $this->facebook,
            'display' => $this->display,
            'province' => [
                'id' => (string) $province->id,
                'name' => $province->name
            ],
            'district' => [
                'id' => (string) $district->id,
                'name' => $district->name
            ],
            'ward' => [
                'id' => $ward['slug'],
                'name' => $ward['name']
            ],
            'address' => $this->address,
        ];

        if (isset(Yii::$app->request->post('ProfileForm')['image_verification']) || !empty($this->active) && $this->active['address'] == 1) {
            $data['image_verification'] = $this->image_verification;
            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'admin',
                'content' => '<b>' . $this->fullname . '</b> vừa upload hình ảnh địa chỉ để xác minh của họ.',
                'url' => Yii::$app->setting->get('siteurl_backend') . '/customer/view/' . \Yii::$app->user->id,
                'status' => 0,
                'created_at' => time()
            ]);
        } else {
            $data['image_verification'] = [];
        }
        // \Yii::$app->db->createCommand()->update('user', $data, 'id=' . \Yii::$app->user->id)->execute();

        return Yii::$app->mongodb->getCollection('user')->update(['_id' => Yii::$app->user->id], ['$set' => $data]);
    }

}
