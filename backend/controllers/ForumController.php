<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use common\models\Question;
use common\models\Answer;
use yii\web\NotFoundHttpException;
use backend\models\ForumFilter;

class ForumController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return parent::behaviors();
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionFilter(){
        $filter = new ForumFilter();
        $dataProvider = $filter->fillter(Yii::$app->request->queryParams);
        $this->view->title = 'Danh sách câu hỏi';
        return $this->render('question', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionQuestion() {
        $query = Question::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => 20],
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $this->view->title = 'Danh sách câu hỏi';
        return $this->render('question', [
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDelquestion($id){
        $count = Answer::find()->where(['question.id'=>$id])->count();
        $question = Question::findOne($id);
        if($count > 0){
              Yii::$app->mongodb->getCollection('answer')->remove(['question.id'=>$id]);
        }
        
        if(!empty($question)){
              Yii::$app->mongodb->getCollection('question')->remove(['_id'=>$id]);
        }
        return $this->redirect('/forum/question');

    }

    public function actionAnswer($id) {
        $query = Answer::find()->where(['question.id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
              'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);

        $this->view->title = 'Danh sách câu trả lời';
        return $this->render('answer', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelanswer($id){
        $answer = Answer::findOne($id);
        if(!empty($answer)){
            Yii::$app->mongodb->getCollection('answer')->remove(['_id'=>$id]);
        }
        return $this->redirect('/forum/answer/'.$answer->question['id']);

    }
}
