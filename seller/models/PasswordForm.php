<?php

namespace seller\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\components\Constant;

/**
 * Login form
 */
class PasswordForm extends Model {

    public $password;
    public $password_new;
    public $password_rep;
    public $_user;

    public function init() {
        $this->_user = User::findOne(Yii::$app->user->id);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['password', 'password_new', 'password_rep'], 'required', 'message' => '{attribute} không được rỗng'],
            ['password_new', 'string', 'min' => 6, 'tooShort' => 'Mật khẩu mới phải trên 6 ký tự!'],
            ['password_rep', 'compare', 'compareAttribute' => 'password_new', 'message' => 'Xác nhận mật khẩu không đúng!'],
            ['password', 'validatePassword']
        ];
    }

    public function attributeLabels() {
        return Constant::USER_LABEL;
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->password)) {
                $this->addError($attribute, 'Mật khẩu hiện tại không chính xác.');
            } elseif ($user->status == Constant::STATUS_NOACTIVE) {
                $this->addError($attribute, 'Tài khoản này chưa kích hoạt.');
            }
        }
    }

    public function save() {
        if ($this->validate()) {
            $this->_user->setPassword($this->password_new);
            if ($this->_user->save()) {
                return $user;
            }
        }

        return null;
    }

}
