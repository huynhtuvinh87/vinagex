<?php

namespace forum\controllers;

use Yii;
use yii\web\Controller;
use forum\models\QuestionForm;
use common\models\Question;
use forum\models\AnswerForm;
use common\models\Answer;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

/**
 * Site controller
 */
class QuestionController extends Controller {

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
        return $this->render('index');
    }

    public function actionCreate() {
        $model = new QuestionForm;
        if ($model->load(yii::$app->request->post()) && $model->save()) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->redirect(['/site/index']);
        }
        return $this->renderAjax('create', [
                    'model' => $model
        ]);
    }

    public function actionUpdate($id) {
        $model = new QuestionForm(['id' => $id]);
        if (Yii::$app->user->id == $model->user_id) {
            if ($model->load(yii::$app->request->post()) && $model->save()) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('update', [
                    'model' => $model
        ]);
    }

    public function actionView($id) {
        $model = Question::findOne($id);
        $answer = new AnswerForm();
        $countAnswer = Answer::find()->where(['question.id' => $id])->count();
        $query = Answer::find()->where(['question.id' => $id])->orderBy(['vote' => SORT_DESC, '_id' => SORT_DESC]);

        $involveQuestion = Question::find()->where(['product_type.id' => $model->product_type['id']])->andWhere(['not in', '_id', $id])->limit(10)->orderBy(['total_answer' => SORT_DESC])->all();

        $view = $model->view;
        $countView = $view + 1;
        $collection = Yii::$app->mongodb->getCollection('question');
        $collection->update(['_id' => $id], ['view' => $countView]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10
            ],
        ]);

        return $this->render('view', [
                    'model' => $model,
                    'countAnswer' => $countAnswer,
                    'answer' => $answer,
                    'involveQuestion' => $involveQuestion,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionRemove($id) {
        $model = Question::findOne($id);
        if (Yii::$app->user->id == $model['user']['id']) {
            $count_answer = Answer::find(['question.id' => $id])->count();
            if (yii::$app->request->post()) {
                $collection = Yii::$app->mongodb->getCollection('question');
                $collection->remove(['_id' => $id]);
                if ($count_answer > 0) {
                    $answer = Answer::deleteAll(['question.id' => $id]);
                }
            }
        }


        return $this->renderAjax('remove', [
                    'model' => $model
        ]);
    }

    public function actionDelete($id) {
        $count_answer = Answer::find(['question.id' => $id])->count();
        if (yii::$app->request->post()) {

            if ($count_answer > 0) {
                $answer = Answer::deleteAll(['question.id' => $id]);
            }
            $collection = Yii::$app->mongodb->getCollection('question')->remove(['_id' => $id]);
            return $this->redirect(['site/index']);
        }

        return $this->renderAjax('delete', [
                    'id' => $id,
        ]);
    }

    public function actionAnswer() {
        if (!empty(Yii::$app->request->post('question_id'))) {
            $model = new AnswerForm(['question_id' => Yii::$app->request->post('question_id')]);
            if ($model->load(Yii::$app->request->post()) && $answer_id = $model->save()) {
                return $this->renderAjax('_answer', [
                            'model' => Answer::findOne($answer_id),
                ]);
            }
        }

        if (!empty(Yii::$app->request->post('answer_id'))) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = new AnswerForm(['answer_id' => Yii::$app->request->post('answer_id')]);

            if ($model->load(Yii::$app->request->post()) && $parent_id = $model->save()) {
                $answer = Answer::findOne(['parent_answer.id' => $parent_id]);
                $key = array_search($parent_id, array_column($answer->parent_answer, 'id'));
                return ['data' => $answer->parent_answer[$key], 'id' => $answer->id];
            }
        }
    }

    public function actionRemoveanswer($id) {
        if (yii::$app->request->post()) {
            $answer = Answer::findOne($id);
            if (!empty($answer)) {
                if (Yii::$app->user->id == $answer['user']['id']) {
                    $question = Question::findOne(['_id' => $answer->question['id']]);
                    Yii::$app->mongodb->getCollection('question')->update(['_id' => $question->id], ['total_answer' => $question->total_answer - 1]);
                    $collection = Yii::$app->mongodb->getCollection('answer')->remove(['_id' => $id]);
                }
            }
            return $id;
        }
        return $this->renderAjax('removeanswer', [
                    'id' => $id,
        ]);
    }

    public function actionDelanswer($id) {
        if (yii::$app->request->post()) {
            $model = Answer::findOne(['parent_answer.id' => $id]);
            $key = array_search($id, array_column($model->parent_answer, 'id'));
            Yii::$app->mongodb->getCollection('answer')->update(['_id' => $model->id], ['$pull' => [
                    'parent_answer' => $model->parent_answer[$key],
            ]]);
            return $id;
        }
        return $this->renderAjax('delanswer', [
                    'id' => $id,
        ]);
    }

    public function actionLike() {
        if (yii::$app->request->post('idAdd')) {
            $countLike = (new Query)->from('like')->where(['question_id' => yii::$app->request->post('idAdd'), 'user_id' => \Yii::$app->user->id])->count();
            if ($countLike == 0) {
                Yii::$app->mongodb->getCollection('like')->insert([
                    'question_id' => yii::$app->request->post('idAdd'),
                    'user_id' => \Yii::$app->user->id,
                ]);
            }
        }

        if (yii::$app->request->post('idRemove')) {
            $countLike = (new Query)->from('like')->where(['question_id' => yii::$app->request->post('idRemove'), 'user_id' => \Yii::$app->user->id])->count();
            if ($countLike == 1) {
                Yii::$app->mongodb->getCollection('like')->remove(['question_id' => yii::$app->request->post('idRemove'), 'user_id' => \Yii::$app->user->id]);
            }
        }
    }

    public function actionVote() {
        $countQuestion = Question::find()->where(['_id' => yii::$app->request->post('idCheck'), 'user_vote.id' => \Yii::$app->user->id])->count();
        if ($countQuestion == 0) {
            if (yii::$app->request->post('idVote')) {
                Yii::$app->mongodb->getCollection('question')->update(['_id' => yii::$app->request->post('idVote')], ['$push' => ['user_vote' => [
                            'id' => \Yii::$app->user->id,
                            'fullname' => \Yii::$app->user->identity->fullname
                ]]]);
                $question = Question::findOne(yii::$app->request->post('idVote'));
                $vote = $question->vote;
                Yii::$app->mongodb->getCollection('question')->update(['_id' => yii::$app->request->post('idVote')], [
                    'vote' => $vote + 1,
                ]);
                return $this->renderAjax('/question/_item', [
                            'model' => Question::findOne(yii::$app->request->post('idVote')),
                ]);
            }
        }
        if ($countQuestion == 1) {
            if (yii::$app->request->post('idUnvote')) {
                $data = Question::findOne(yii::$app->request->post('idUnvote'));
                $key = array_search(\Yii::$app->user->id, array_column($data->user_vote, 'id'));
                Yii::$app->mongodb->getCollection('question')->update(['_id' => yii::$app->request->post('idUnvote')], ['$pull' => [
                        'user_vote' => $data->user_vote[$key]
                ]]);
                $vote = $data->vote;
                Yii::$app->mongodb->getCollection('question')->update(['_id' => yii::$app->request->post('idUnvote')], [
                    'vote' => $vote - 1,
                ]);
                return $this->renderAjax('/question/_item', [
                            'model' => Question::findOne(yii::$app->request->post('idUnvote')),
                ]);
            }
        }
    }

    public function actionVoteanswer() {
        $countVote = Answer::find()->where(['_id' => yii::$app->request->post('idCheck'), 'user_vote.id' => \Yii::$app->user->id])->count();
        if ($countVote == 0) {
            if (yii::$app->request->post('idVote')) {
                Yii::$app->mongodb->getCollection('answer')->update(['_id' => yii::$app->request->post('idVote')], ['$push' => ['user_vote' => [
                            'id' => \Yii::$app->user->id,
                            'fullname' => \Yii::$app->user->identity->fullname
                ]]]);
                $answer = Answer::findOne(yii::$app->request->post('idVote'));
                $vote = $answer->vote;
                Yii::$app->mongodb->getCollection('answer')->update(['_id' => yii::$app->request->post('idVote')], [
                    'vote' => $vote + 1,
                ]);
                return $this->renderAjax('/question/_answer', [
                            'model' => Answer::findOne(yii::$app->request->post('idVote')),
                ]);
            }
        }

        if ($countVote == 1) {
            if (yii::$app->request->post('idUnvote')) {
                $data = Answer::findOne(yii::$app->request->post('idUnvote'));
                $key = array_search(\Yii::$app->user->id, array_column($data->user_vote, 'id'));
                Yii::$app->mongodb->getCollection('answer')->update(['_id' => yii::$app->request->post('idUnvote')], ['$pull' => [
                        'user_vote' => $data->user_vote[$key]
                ]]);
                $vote = $data->vote;
                Yii::$app->mongodb->getCollection('answer')->update(['_id' => yii::$app->request->post('idUnvote')], [
                    'vote' => $vote - 1,
                ]);
                return $this->renderAjax('/question/_answer', [
                            'model' => Answer::findOne(yii::$app->request->post('idUnvote')),
                ]);
            }
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
