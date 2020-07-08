<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\components\Constant;

class ProfileForm extends Model {

    public $fullname;
    public $email;
    public $phone;
    public $gender;

    public function init() {
        parent::init();
        $this->fullname = \Yii::$app->user->identity->fullname;
        $this->email = \Yii::$app->user->identity->email;
        $this->phone = \Yii::$app->user->identity->phone;
        $this->gender = \Yii::$app->user->identity->gender;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['fullname', 'required', 'message' => 'Họ tên không được bỏ trống'],
            ['gender', 'string'],
            ['phone', 'integer'],
        ];
    }

    public function attributeLabels() {
        return [
            'fullname' => 'Họ tên',
            'gender' => 'Giới tính',
            'phone' => 'Điện thoại'
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
        $data = [
            'fullname' => $this->fullname,
            'email' => $this->email,
            'gender' => $this->gender,
            'phone' => $this->phone
        ];
        \Yii::$app->db->createCommand()->update('user', $data, 'id=' . \Yii::$app->user->id)->execute();
        return TRUE;
    }

}
