<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class ProfileForm extends Model {

    public $id;
    public $username;
    public $email;
    public $firstname;
    public $lastname;
    public $address;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['id', 'integer'],
            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'firstname', 'lastname', 'email'], 'required'],
            ['username', 'validateUsername'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['email', 'firstname', 'lastname', 'address', 'phone'], 'string', 'max' => 255],
            ['email', 'validateEmail'],
        ];
    }

    public function validateUsername($attribute, $params) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['username' => $this->username])->one();
            if (!empty($model)) {
                if ($model->id != $this->id)
                    $this->addError($attribute, $this->username . \Yii::t('app', 'already exists'));
            }
        }
    }

    public function validateEmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $model = User::find()->where(['email' => $this->email])->one();
            if (!empty($model)) {
                if ($model->id != $this->id)
                    $this->addError($attribute, $this->email . \Yii::t('app', 'already exists'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => \Yii::t('app', 'Username'),
            'email' => \Yii::t('app', 'Email'),
            'firstname' => \Yii::t('app', 'First Name'),
            'lastname' => \Yii::t('app', 'Last Name'),
            'address' => \Yii::t('app', 'Address')
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $user = User::findOne($this->id);
            $user->username = $this->username;
            $user->email = $this->email;
            $user->firstname = $this->firstname;
            $user->lastname = $this->lastname;
            $user->address = $this->address;
            $user->save();
            return true;
        }
        return false;
    }

}
