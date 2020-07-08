<?php

namespace frontend\controllers;

use Yii;
use common\models\Page;

class HelpController extends \yii\web\Controller {

    public function init() {
        $this->layout = "help";
    }

    public function actionIndex($id){
        $model = Page::findOne($id);
        return $this->render('index',['model'=>$model]);
    }

    public function actionJoin() {
        return $this->render('join');
    }

    public function actionProduct(){
    	return $this->render('product');
    }

    public function actionOrder(){
    	return $this->render('order');
    }

}
