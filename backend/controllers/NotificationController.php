<?php

namespace backend\controllers;

use Yii;
use common\models\Notification;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

class NotificationController extends \backend\components\BackendController {

    public function init() {
        parent::init();
    }

    public function actionIndex($id = 0) {
        $query = Notification::find()->where(['type' => 'admin', 'status' => (int)$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = 'Thông báo';
        $unread = (new Query)->from('notification')->where(['type' => 'admin','status' => 0])->count();
        $read = (new Query)->from('notification')->where(['type' => 'admin','status' => 1])->count();
        return $this->render('index', ['dataProvider' => $dataProvider, 'unread' => $unread, 'read' => $read]);
    }

    public function actionStatus() {
        $post = Yii::$app->request->post();
        return Yii::$app->mongodb->getCollection('notification')->update(['_id' => $post['id']], ['status' => (int) 1]);
    }

    public function actionCheckread() {
        $post = Yii::$app->request->post();
        Yii::$app->mongodb->getCollection('notification')->update(['_id' => $post['id']], ['status' => 1]);
        return $status;
    }

    public function actionRemove() {
        $post = Yii::$app->request->post();
        Yii::$app->mongodb->getCollection('notification')->remove(['_id' => $post['id']]);
        return 1;
    }

    public function actionCheckall() {
        Yii::$app->mongodb->getCollection('notification')->update(['type' => 'admin'], ['status' => (int) 1]);
        return $this->redirect('/notification');
    }

}
