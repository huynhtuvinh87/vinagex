<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\components\Constant;

/**
 * Login form
 */
class LoginForm extends Model {

    public $email;
    public $password;
    public $rememberMe;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['email', 'password'], 'required', 'message' => '{attribute} không được bỏ trống'],
            ['email', 'trim'],
            ['email', 'email', 'message' => 'Email không hợp lệ'],
            ['email', 'string', 'max' => 25],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Email',
            'password' => 'Mật khẩu'
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Email hoặc mật khẩu không chính xác.');
            }
            if(!$user || $user->status == Constant::STATUS_PENDING){
                $this->addError($attribute, 'Tài khoản này chưa kích hoạt.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = User::find()->where(['email' => $this->email])->one();
        }

        return $this->_user;
    }

}
