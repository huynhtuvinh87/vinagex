<?php

namespace frontend\controllers;

use Yii;
use frontend\controllers\FrontendController;
use common\models\elastics\Search;
use common\models\Category;

/**
 * Site controller
 */
class SearchController extends FrontendController {

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

        $elastic = new Search();
        $result = $elastic->search(Yii::$app->request->queryParams);
        var_dump($result); exit;
        $query = Yii::$app->request->queryParams;
        $search = new Search();
        $params = Yii::$app->request->getQueryParams();
        $search->attributes = $params;
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        $title = Yii::t('common', 'Tìm kiếm');
        if (!empty($_GET['category'])) {
            $category = Category::findOne($_GET['category']);
            $title .= $category->title . ' ';
        }
        if (!empty($_GET['keywords'])) {
            $title .= $_GET['keywords'];
        }
        $this->view->title = $title;
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

}
