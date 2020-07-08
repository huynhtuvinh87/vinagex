<?php

namespace forum\controllers;

use Yii;
use yii\web\Controller;
use common\models\Category;

class AjaxController extends Controller {

    public function init() {
        parent::init();
        $this->enableCsrfValidation = false;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionParent(){
        $id = $_POST['category_id'];
        $category = Category::findOne($id);
        $parent = array();
        foreach ($category['parent'] as $value) {
            $parent[(string)$value['id']] = $value['title'];
        }
        return $parent;
    }


}
