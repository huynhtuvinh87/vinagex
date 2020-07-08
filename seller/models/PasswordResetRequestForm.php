<?php

namespace seller\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Setting;
use common\models\SendMail;
use common\components\Constant;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

    public $email;
    public $_setting;

    public function init() {
        parent::init();
        $this->_setting = Setting::findOne(['key' => 'config']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Email này không tồn tại trong hệ thống.'
            ],
        ];
    }

    public function attributeLabels() {
        return [
            'email' => 'Địa chỉ email'
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail() {
        /* @var $user User */
        $user = User::findOne([
                    'status' => Constant::STATUS_ACTIVE,
                    'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        return SendMail::send('reset_password', $user, [$this->_setting->email => $this->_setting->name], 'Quên mật khẩu', $user->email);
    }

}
