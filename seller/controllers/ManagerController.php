<?php

namespace seller\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\components\Constant;

class ManagerController extends Controller {

    public function init() {
        parent::init();
        if (\Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_seller')));
        }
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update', 'create', 'delete', 'view', 'status', 'password'],
                'rules' => [
                    [
                        'actions' => ['index', 'update', 'create', 'delete', 'view', 'status', 'password'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    return Yii::$app->response->redirect(['/site/url']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'status' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

}
