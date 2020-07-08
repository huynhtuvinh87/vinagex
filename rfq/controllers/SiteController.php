<?php

namespace rfq\controllers;

use Yii;
use yii\web\Controller;
use common\components\Constant;
use common\models\Category;
use rfq\models\RfqFilter;

/**
 * Site controller
 */
class SiteController extends Controller {

    public function init() {
        parent::init();
        
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        $category = Category::find()->orderBy(['order' => SORT_ASC])->all();
        $filter = new RfqFilter();
        $dataProvider = $filter->fillter(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider, 'category' => $category]);
    }

    public function actionLogin() {
        if (Yii::$app->user->isGuest) {
            $this->redirect(Constant::domain('id') . 'login?url=' . Constant::domain('rfq'));
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        $this->redirect(Yii::$app->setting->get('siteurl'));
    }

}
