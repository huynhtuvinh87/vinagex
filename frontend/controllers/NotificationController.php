<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Notification;
use yii\filters\AccessControl;
use frontend\controllers\FrontendController;

class NotificationController extends FrontendController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Notification::find()->where(['owner' => \Yii::$app->user->id])->andWhere(['not in', 'type', ['admin']]),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $this->view->title = Yii::t('common', 'Thông báo');
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionStatus() {
        $post = Yii::$app->request->post();
        return Yii::$app->mongodb->getCollection('notification')->update(['_id' => $post['id']], ['status' => (int) 1]);
    }

    public function actionCheckall() {
        Notification::updateAll(['status' => 1], ['AND',
            ['owner' => \Yii::$app->user->id],
            ['NOT IN', 'type', ['admin']]
        ]);
        return $this->redirect('/notification');
    }

}
