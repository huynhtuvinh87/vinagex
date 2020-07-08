<?php

namespace frontend\controllers;

use Yii;
use frontend\controllers\FrontendController;
use frontend\models\ProductFilter;

/**
 * Filter controller
 */
class FilterController extends FrontendController {

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
        $filter = new ProductFilter();
        $dataProvider = $filter->fillter(Yii::$app->request->queryParams);
        $this->view->title = \Yii::t('common', 'Tìm kiếm');
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }


}
