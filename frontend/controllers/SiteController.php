<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ContactForm;
use common\models\Product;
use common\models\Category;
use yii\web\Cookie;
use yii\helpers\Json;
use common\components\Constant;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'message'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'message'],
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

    public function init() {
        parent::init();
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
        $this->view->title = Yii::t('common', 'Sàn giao dịch nông sản Việt Nam - Sàn mua bán trái cây, hoa tươi, rau củ');
        $data['available'] = Product::active()->andWhere(['time_to_sell' => Product::TIMETOSELL_1])->orderBy(['created_at' => SORT_DESC])->limit(10)->all();
        $data['is_reservation'] = Product::active()->andWhere(['time_to_sell' => Product::TIMETOSELL_2])->orderBy(['created_at' => SORT_DESC])->limit(10)->all();
        $data['category'] = Category::find()->orderBy(['order' => SORT_ASC])->all();
        return $this->render('index', ['data' => $data]);
    }

    public function actionProvince($id) {
        $province = \common\models\Province::findOne($id);
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'province',
            'value' => Json::encode([
                'id' => $id,
                'name' => $province->name,
            ]),
            'expire' => time() + 604800,
        ]));
        if (!empty($_GET['url'])) {
            return $this->redirect($_GET['url']);
        } else {
            return $this->goHome();
        }
    }

    public function actionLanguage($code) {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'language',
            'value' => Json::encode([
                'code' => $code,
                'name' => Constant::LANGUAGE[$code],
            ]),
            'expire' => time() + 604800,
        ]));
        if (!empty($_GET['url'])) {
            return $this->redirect($_GET['url']);
        } else {
            return $this->goHome();
        }
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
