<?php

namespace seller\controllers;

use Yii;
use common\models\Notification;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;


class NotificationController extends ManagerController {

    public function init() {
        parent::init();
    }

    public function actionIndex() {
        $query = Notification::find()->where(['owner'=>Yii::$app->user->id])->andWhere(['not in','type',['admin']]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = 'Thông báo của bạn';
        return $this->render('index',['dataProvider'=>$dataProvider]);
    }

    public function actionStatus(){
        $post = Yii::$app->request->post();
        return Yii::$app->mongodb->getCollection('notification')->update(['_id'=>$post['id']],['status'=>(int)1]);
    }

    public function actionCheckread(){
        $post = Yii::$app->request->post();
        $model = (new Query)->from('notification')->where(['_id'=>$post['id']])->one();
        $status = $model['status'] == 0?1:0;
        Yii::$app->mongodb->getCollection('notification')->update(['_id'=>$post['id']],['status'=>(int)$status]);
        return $status;
        
    }

    public function actionCheckall(){
        Notification::updateAll(['status'=>1], ['AND',
            ['owner'=>\Yii::$app->user->id],
            ['NOT IN', 'type', ['admin']]
        ]);
        return $this->redirect('/notification');
    }

}
