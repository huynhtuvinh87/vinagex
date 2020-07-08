<?php

namespace backend\models;

use common\models\User;
use common\models\UserMeta;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $fullname;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'fullname', 'password', 'email'], 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User'],
            ['username', 'string', 'min' => 6, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['email'], 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User'],
            ['password', 'required'],
            ['password', 'string', 'min' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => 'Tên đăng nhập',
            'fullname' => 'Họ tên',
            'email' => 'Email',
            'password' => 'Mật khẩu'
        ];
    }

    public function metaKeys() {
        return ['firstname', 'lastname'];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->fullname = $this->fullname;
            $user->role = 'admin';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
//        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
