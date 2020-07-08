<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ProfileForm;
use frontend\models\PasswordForm;
use common\models\SendMail;
use yii\web\NotFoundHttpException;
use common\components\Constant;
use common\models\Setting;
use common\models\User;
use yii\mongodb\Query;
use yii\data\ActiveDataProvider;
use frontend\controllers\FrontendController;

/**
 * Site controller
 */
class UserController extends FrontendController {

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
                'only' => ['logout', 'signup', 'profile'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'profile'],
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
        return parent::beforeAction($action);
    }

    public function actionProfile() {
        $this->layout = 'profile';
        $model = new ProfileForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('common', 'Bạn đã cập nhật thông tin cá nhân thành công.'));
            return $this->redirect('/user/profile');
        }
        return $this->render('profile', [
                    'model' => $model
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {


        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->redirect(Yii::$app->setting->get('siteurl_id'));
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
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Bạn đã đăng ký thành công, Vui lòng kiểm tra email để kich hoạt tài khoản.'));
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
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Kiểm tra email của bạn để được hướng dẫn thêm.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'Rất tiếc, chúng tôi không thể đặt lại mật khẩu cho địa chỉ email này.'));
            }
        }

        return $this->render('forgetPassword', [
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
    public function actionResetpassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('common', 'Đã lưu mật khẩu mới.'));
            return $this->redirect(['login']);
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionPassword() {
        $this->layout = 'profile';
        $model = new PasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('success', Yii::t('common', 'Bạn đã thay đổi mật khẩu thành công.'));
            return $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login');
        }
        return $this->render('password', ['model' => $model]);
    }

    public function actionVerify() {
        $this->layout = 'profile';
        return $this->render('verify');
    }

    public function actionView($id) {
        $user = User::find()->where(['_id' => $id])->andWhere(['not in', 'role', [Constant::ROLE_SUPERADMIN, Constant::ROLE_ADMIN]])->one();
        if (!$user) {
            throw new NotFoundHttpException(Yii::t('common', 'Tài khoản không tồn tại.'));
        }
        if ($user->role == Constant::ROLE_SELLER && $user->public == 1) {
            return $this->redirect(['/nha-cung-cap/' . $user->username . '-' . $user->id]);
        }

        $review_buyer = (new Query)->from('review_buyer')->where(['buyer.id' => $id])->limit(20)->orderBy(['_id' => SORT_DESC])->all();

        $dataProvider = new ActiveDataProvider([
            'query' => (new Query)->from('order')->where(['buyer.id' => $id, 'status' => Constant::STATUS_ORDER_FINISH])->limit(5)->orderBy(['created_at' => SORT_DESC]),
            'pagination' => false,
        ]);
        return $this->render('view', [
                    'user' => $user,
                    'review_buyer' => $review_buyer,
                    'dataProvider' => $dataProvider
        ]);
    }

}
