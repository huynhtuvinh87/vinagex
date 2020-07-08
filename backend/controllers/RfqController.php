<?php

namespace backend\controllers;

use Yii;
use backend\components\BackendController;
use backend\models\RfqFilter;
use yii\mongodb\Query;
use common\components\Constant;
use yii\data\ActiveDataProvider;

class RfqController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $search = new RfqFilter();
        $dataProvider = $search->filter(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

    public function actionDoaction() {
        if ($post = Yii::$app->request->post()) {
            $rfq = (new Query)->from('rfq')->where(['_id' => $post['id']])->one();
            if ($rfq) {
                return Yii::$app->mongodb->getCollection('rfq')->update(['_id' => $post['id']], ['status' => (int) $post['status']]);
            }
        }
    }

    public function actionStatus() {
        if (!empty(Yii::$app->request->post('selection')) && $post = Yii::$app->request->post()) {
            foreach ($post['selection'] as $value) {
                Yii::$app->mongodb->getCollection('rfq')->update(['_id' => $value], ['status' => Constant::STATUS_PENDING]);
            }
            \Yii::$app->getSession()->setFlash('success', 'Duyệt thành công');
        }
        return $this->redirect(['index']);
    }

    public function actionDelete($id) {
        $rfq = (new Query)->from('rfq')->where(['_id' => $id])->one();
        if ($rfq) {
            Yii::$app->mongodb->getCollection('rfq')->remove(['_id' => $id]);
            \Yii::$app->getSession()->setFlash('success', 'Xóa thành công');
        }
        return $this->redirect(['index']);
    }

    public function actionView($id) {
        $query = (new Query)->from('rfq_offer')->where(['rfq.id' => $id])->orderBy('created_at DESC');
        $this->view->title = $query->one()['rfq']['title'];
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('view', [
                    'dataProvider' => $dataProvider
        ]);
    }

}
