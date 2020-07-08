<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\components\BackendController;
use backend\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Forgot;
use common\models\User;
use common\models\Product;
use common\models\Message;
use common\models\Category;

/**
 * Site controller
 */
class SiteController extends BackendController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'signup', 'forgot'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'import'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $totalMember = User::find()->where(['role' => 'member'])->count();
        $totalSeller = User::find()->where(['role' => 'seller'])->count();
        $totalProduct = Product::find()->count();
        $totalMessage = Message::find()->where(['order' => 2])->count();
        $category = Category::find()->all();
        return $this->render('index', [
                    'totalMember' => $totalMember,
                    'totalSeller' => $totalSeller,
                    'totalProduct' => $totalProduct,
                    'totalMessage' => $totalMessage,
                    'category' => $category,
        ]);
    }

    public function actionLogin() {
        $this->layout = "login";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionForgot() {
        $this->layout = 'login';
        $model = new Forgot();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->mailer->compose('forgot')
                    ->setFrom('giicmsvn@gmail.com')
                    ->setTo($model->email)
                    ->setSubject('Lost your password')
                    ->send();
        }
        return $this->render('forgot', [
                    'model' => $model
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $this->layout = 'login';
            return $this->render('error', ['exception' => $exception]);
        }
    }

 

}
