<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\mongodb\Query;
class TestmailController extends Controller {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionForgetpassword() {
        return $this->render('forgetPassword');
    }

    public function actionOrdersending() {
        $query = (new Query)->from('order')->where(['code' => 824805329])->one();
        return $this->render('buyercancel', ['data' => $query]);
    }

}
