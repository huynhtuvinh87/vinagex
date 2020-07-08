<?php

namespace seller\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use seller\models\PasswordResetRequestForm;
use seller\models\ResetPasswordForm;
use seller\models\SellerForm;
use seller\models\LoginInfo;
use common\models\Statics;
use common\models\StaticItem;
use common\components\Constant;
use yii\mongodb\Query;
use common\models\Order;
use common\models\Review;
use yii\data\ActiveDataProvider;
/**
 * Site controller
 */
class SiteController extends Controller {

    public function init() {
        parent::init();
        if (\Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_seller')));
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    return Yii::$app->response->redirect(['/site/url']);
                },
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action) {
        if ($action->id == 'error') {
            $this->layout = 'error';
        }
        return parent::beforeAction($action);
    }

    public function actionLogin(){
        
    }

    public function actionUrl() {
        return $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_seller')));
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $notification = (new Query)->from('notification')->where(['owner'=>\Yii::$app->user->id])->andWhere(['not in','type',['admin']])->orderBy(['_id'=>SORT_DESC])->limit(10)->all();
        $static =  Yii::$app->mongodb->getCollection('static')->aggregate([
            ['$match' => ['owner' => \Yii::$app->user->id]],
                [
                    '$group' => [
                    '_id' => ['product' => '$product'],
                    'totalQtt' => ['$sum' => '$quantity'],
                    'totalAmount' => ['$sum' => ['$multiply' => ['$quantity', '$price']]],
                    'count' => [
                    '$sum' => 1
                        ],
                    ],
                ],
            ]);
        $order_finish = (new Query)->from('order')->where(['owner.id' => \Yii::$app->user->id])->all();

        $dataProviderHistory = new ActiveDataProvider([
            'query' => Order::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ORDER_FINISH])->orderBy(['_id' => SORT_DESC]),
            'pagination' => [
            'defaultPageSize' => 10
            ],
        ]);
        return $this->render('index',[
            'notification' => $notification,
            'order_finish' => $order_finish,
            'static' => $static,
            'dataProviderHistory' => $dataProviderHistory,
        ]);
    }

    public function actionStatic($id) {
        $collection = Yii::$app->mongodb->getCollection('static');
        $static = $collection->aggregate([
            ['$match' => ['product.id' => $id]],
            [
                '$group' => [
                    '_id' => ['province' => '$province'],
                    'totalQtt' => ['$sum' => '$quantity'],
                    'totalAmount' => ['$sum' => ['$multiply' => ['$quantity', '$price']]],
                    'count' => [
                        '$sum' => 1
                    ],
                ],
            ],
        ]);
        return $this->renderAjax('staticItem', ['static' => $static]);
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

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $this->layout = 'login';
        $model = new SellerForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->save()) {
                return $this->redirect(['auth', 'id' => $user->auth_key]);
            }
        }
        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionAuth() {
        $this->layout = 'login';
        $user = User::findOne(['auth_key' => $_GET['id']]);
        $model = new LoginInfo();
        $model->auth_key = $user->auth_key;
        $model->email = $user->email;
        $model->phone = $user->phone;
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->save()) {
                Yii::$app->session->setFlash('success', 'Bạn đã đăng ký tài khoản bán hàng thành công.');
                return $this->redirect(['login']);
            }
        }
        return $this->render('auth', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $this->layout = 'login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->redirect(['request-password-reset']);
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        $this->layout = 'login';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
