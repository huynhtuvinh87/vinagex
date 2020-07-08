<?php

namespace seller\controllers;

use Yii;
use common\models\User;
use frontend\models\PasswordForm;
use frontend\models\ProfileForm;

class UserController extends ManagerController {

    public $_user;

    public function init() {
        $this->_user = User::findOne(Yii::$app->user->id);
    }

    public function actionIndex() {
        $model = Account::findProfile();
        return $this->render('index', ['model' => $model]);
    }

    public function actionUpdate() {
        $model = new ProfileForm();
        if ($model->load(Yii::$app->request->post()) && $model->edit()) {
            Yii::$app->session->setFlash('success', 'Bạn đã cập nhật thông tin tài khoản thành công.');
            return $this->redirect(['update']);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionPassword() {
        $model = new PasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->user->logout();
            $this->redirect(['site/login']);
        }
        return $this->render('password', ['model' => $model, 'user' => $user]);
    }

}
