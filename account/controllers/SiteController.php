<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use account\models\LoginForm;
use common\components\Constant;

/**
 * Site controller
 */
class SiteController extends Controller {

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
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/login']);
        } else {
            $this->redirect(Yii::$app->setting->get('siteurl'));
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionConnect() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/login?url=' . Yii::$app->setting->get('siteurl_id') . '/site/connect']);
        } else {
            $auth = Yii::$app->security->generateRandomString();
            if (YII_ENV_DEV) {
                $domain = 'http://canvanchuyen.loc';
            } else {
                $domain = 'http://canvanchuyen.com';
            }
            $find = Yii::$app->mongodb1->getCollection('user')->findOne(['phone' => \Yii::$app->user->identity->phone, 'transport_code' => \Yii::$app->user->identity->transport_code]);
            if ($find) {
                $this->redirect($domain . '/dang-nhap');
            }

            Yii::$app->mongodb1->getCollection('user')->insert([
                "fullname" => \Yii::$app->user->identity->fullname,
                'phone' => \Yii::$app->user->identity->phone,
                'auth_key' => $auth,
                'transport_code' => \Yii::$app->user->identity->transport_code,
                'role' => 5,
                'created_at' => time(),
                'updated_at' => time()
            ]);
            $this->redirect($domain . '/dang-nhap?token=' . $auth);
        }
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
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (!empty($_GET['url'])) {
                $this->redirect(Constant::url($_GET['url']));
            } else {
                $this->redirect(Yii::$app->setting->get('siteurl'));
            }
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

}
