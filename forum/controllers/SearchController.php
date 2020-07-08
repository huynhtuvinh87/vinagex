<?php

namespace forum\controllers;

use Yii;
use yii\web\Controller;
use forum\models\QuestionFilter;
use common\models\Category;
use common\models\Question;

/**
 * Site controller
 */
class SearchController extends Controller {

    public function init() {
        parent::init();
        $this->enableCsrfValidation = false;
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        $category = Category::find()->all();
        ;
        $filter = new QuestionFilter();
        $question = new Question();
        $dataProvider = $filter->fillter(Yii::$app->request->queryParams);

        if (!empty(Yii::$app->request->queryParams['vote'])) {
            $this->view->title = "Top bình chọn";
        }
        if (!empty(Yii::$app->request->queryParams['news'])) {
            $this->view->title = "Mới nhất";
        }
        if (!empty(Yii::$app->request->queryParams['answers'])) {
            $this->view->title = "Trả lời nhiều nhất";
        }
        if (!empty(Yii::$app->request->queryParams['category'])) {
            $this->view->title = $filter->category['title'];
        }
        if (!empty(Yii::$app->request->queryParams['keywords'])) {
            $this->view->title = Yii::$app->request->queryParams['keywords'];
        }
        if (!empty(Yii::$app->request->queryParams['product_type'])) {
            $k = array_search(Yii::$app->request->queryParams['product_type'], array_column($filter->category['parent'], 'slug'));
            $this->view->title = $filter->category['parent'][$k]['title'];
        }

        return $this->render('/site/index', [
                    'dataProvider' => $dataProvider,
                    'category' => $category,
                    'question' => $question
        ]);
    }

}
