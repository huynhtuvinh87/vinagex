<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\SignupForm;
use common\models\SendMail;
use yii\web\NotFoundHttpException;
use common\components\Constant;
use common\models\Setting;
use common\models\User;

/**
 * Site controller
 */
class UserController extends Controller {

    public $_setting;

    public function init() {
        parent::init();
        $this->_setting = Setting::findOne(['key' => 'config']);
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
        if (Yii::$app->devicedetect->isMobile()) {
            Yii::$app->controller->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
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

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('success', 'Bạn đã đăng ký thành công, Vui lòng kiểm tra email để kich hoạt tài khoản.');
                SendMail::send('signup', $user, [$this->_setting->email => $this->_setting->name], $this->_setting->name, $user->email);
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionActive($auth) {
        $user = User::findOne(['auth_key' => $auth]);
        if (!$user) {
            throw new NotFoundHttpException('This page does not exist in the system.');
        }
        $user->status = Constant::STATUS_ACTIVE;
        if ($user->save()) {
            return $this->redirect(['login']);
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionForgetpassword() {
        $this->layout = 'login';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Kiểm tra email của bạn để được hướng dẫn thêm.');
            } else {
                Yii::$app->session->setFlash('error', 'Rất tiếc, chúng tôi không thể đặt lại mật khẩu cho địa chỉ email này.');
            }
        }

        return $this->render('forgetPassword', [
                    'model' => $model,
        ]);
    }

  

}
