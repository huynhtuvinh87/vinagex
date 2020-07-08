<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\components\Constant;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $fullname;
    public $email;
    public $password;
    public $gender;

    public function init() {
        parent::init();
        
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['fullname', 'required','message'=>'Họ tên không được bỏ trống'],
            ['email', 'trim'],
            ['email', 'required','message' => 'Email không được bỏ trống'],
            ['email', 'email' , 'message'=>'Email không hợp lệ'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email này đã tồn tại trong hệ thống.'],
            ['password', 'required','message'=>'Mật khẩu không được bỏ trống'],
            ['password', 'string', 'min' => 6],
            ['gender', 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'fullname' => 'Họ tên',
            'gender'=>'Giới tính',
            'password' => 'Mật khẩu'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->email = $this->email;
        $user->fullname = $this->fullname;
        $user->gender = $this->gender;
        $user->setPassword($this->password);
        $user->role = Constant::ROLE_MEMBER;
        $user->avatar = Constant::NO_IMAGE  ;
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

}
