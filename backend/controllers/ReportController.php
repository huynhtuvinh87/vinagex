<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use backend\components\BackendController;

class ReportController extends BackendController {

    public function init() {
        parent::init();
    }

    public function actionIndex() {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $query = (new Query)->from('report')->where(['_id' => $id])->orderBy('created_at DESC');
        } else {
            $query = (new Query)->from('report')->orderBy('created_at DESC');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = 'Báo cáo vi phạm';

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionStatus($id) {
        Yii::$app->mongodb->getCollection('report')->update(['_id' => $id], ['status' => 1]);
        return $this->redirect(['index']);
    }

    public function actionDelete($id) {
        Yii::$app->mongodb->getCollection('report')->remove(['_id' => $id]);
        return $this->redirect(['index']);
    }

}
