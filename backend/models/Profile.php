<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * Signup form
 */
class Profile extends User {

    public $id;
    public $firstname;
    public $lastname;

    const STATUS_ACTIVE = 2;
    const STATUS_NOACTIVE = 3;

    public function init() {
        parent::init();
        if ($this->id) {
            $model = User::findOne($this->id);
            $this->attributes = $model->attributes;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['_id', 'string'],
            ['fullname', 'string'],
            ['fullname', 'required', 'message' => '{attribute} không được rỗng.'],
            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'firstname', 'lastname', 'email'], 'required', 'message' => '{attribute} không được rỗng.'],
            ['username', 'validateUsername'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['email', 'firstname', 'lastname'], 'string', 'max' => 255],
            ['email', 'validateEmail'],
        ];
    }

    public function validateUsername($attribute, $params) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['username' => $this->username])->one();
            if (!empty($model)) {
                if ($model->_id != $this->_id)
                    $this->addError($attribute, $this->username . ' đã tồn tại trong hệ thống.');
            }
        }
    }

    public function validateEmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['email' => $this->email])->one();
            if (!empty($model)) {
                if ($model->_id != $this->_id)
                    $this->addError($attribute, $this->email . ' đã tồn tại trong hệ thống.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => Yii::t('app', 'Username'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'email' => 'Email'
        ];
    }

    public static function find() {
        return parent::find();
    }

    public function profile() {
        if ($this->validate()) {
            $user = User::findOne($this->_id);
            $user->username = $this->username;
            $user->email = $this->email;
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    public function metaKeys() {
        return ['firstname', 'lastname'];
    }

    public function status() {
        return [
            self::STATUS_ACTIVE => 'Xác thực',
            self::STATUS_NOACTIVE => 'Chưa xác thực'
        ];
    }

}
