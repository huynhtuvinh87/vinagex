<?php

namespace forum\controllers;

use Yii;
use yii\web\Controller;
use forum\models\QuestionFilter;
use common\models\Category;
use common\models\Question;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller {

    public function init() {
        parent::init();
        $this->enableCsrfValidation = false;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'myquestion'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'myquestion'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    'denyCallback' => function($rule, $action) {
                        return Yii::$app->response->redirect(['/site/url']);
                    },
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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

    public function beforeAction($action) {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionUrl() {
        return $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_forum')));
    }

    public function actionIndex() {
        $filter = new QuestionFilter();
        $dataProvider = $filter->fillter(Yii::$app->request->queryParams);
        $category = Category::find()->all();
        $question = new Question();
        $this->view->title = "Diễn đàn trao đổi";
        return $this->render('index', ['dataProvider' => $dataProvider, 'question' => $question, 'category' => $category]);
    }

    public function actionMyquestion() {
        $query = Question::find()->where(['user.id' => Yii::$app->user->id]);
        $category = Category::find()->all();
        $question = new Question();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = "Danh sách câu hỏi của bạn";
        return $this->render('index', ['dataProvider' => $dataProvider, 'question' => $question, 'category' => $category]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        $this->redirect(Yii::$app->setting->get('siteurl'));
    }

}
