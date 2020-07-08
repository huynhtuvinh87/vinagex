<?php

namespace account\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\components\Constant;
use yii\mongodb\Query;

/**
 * Login form
 */
class LoginForm extends Model {

    public $emailorphone;
    public $password;
    public $rememberMe;
    public $url;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['emailorphone', 'password'], 'required', 'message' => '{attribute} không được bỏ trống'],
            ['emailorphone', 'trim'],
            [['emailorphone', 'url'], 'string'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels() {
        return [
            'emailorphone' => 'Email hoặc số điện thoại',
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
            if (!$user || $user->status == Constant::STATUS_PENDING) {
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
            $this->_user = User::find()->where(['email' => $this->emailorphone])->orWhere(['phone' => $this->emailorphone])->one();
        }

        return $this->_user;
    }

    public function getUrl() {
        $log = (new Query())->from('log')->where(['ip' => Yii::$app->getRequest()->getUserIP(), 'type' => 'url'])->one();
        return $log['goBack'];
    }

}
