<?php

namespace backend\components;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\Constant;

class BackendController extends Controller {


    public function init() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_backend')));
        } else {
            
            if (!in_array(\Yii::$app->user->identity->role, ['superadmin', 'admin'])) {
                return $this->redirect(Yii::$app->setting->get('siteurl'));
            }
        }
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                // everything else is denied
                ],
            ],
        ];
    }

}
