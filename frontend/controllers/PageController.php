<?php

namespace frontend\controllers;

use frontend\controllers\FrontendController;
use common\models\Page;

class PageController extends FrontendController {

    public function init() {
        parent::init();
        $this->layout = "page";
    }

    public function actionIndex() {
        $slug = $_GET['slug'];
        $model = Page::findOne(['slug' => $slug]);
        return $this->render('index', ['model' => $model]);
    }

    public function actionJoin() {
        return $this->render('join');
    }

    public function actionProduct() {
        return $this->render('product');
    }

    public function actionOrder() {
        return $this->render('order');
    }

}
