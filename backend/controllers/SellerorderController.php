<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\Order;
use common\models\SellerOrder;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\ProductOrder;
use common\components\Constant;
use backend\components\BackendController;

class SellerorderController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }


    public function actionPending() {

        $dataProvider = new ActiveDataProvider([
            'query' => SellerOrder::find()->where(['status' => Constant::STATUS_PENDING])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Đơn hàng đang xử lý';
        return $this->render('pending', ['dataProvider' => $dataProvider]);
    }

    public function actionSending() {

        $dataProvider = new ActiveDataProvider([
            'query' => SellerOrder::find()->where(['status' => Constant::STATUS_ORDER_DGH])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Đơn hàng đang giao';
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    public function actionComplete() {

        $dataProvider = new ActiveDataProvider([
            'query' => SellerOrder::find()->where(['status' => Constant::STATUS_ORDER_GHTC])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Đơn hàng thành công';
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = Order::findOne(['code' => $id]);
        if (!$model) {
            throw new NotFoundHttpException('This page does not exist in the system.');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => ProductOrder::find()->where(['order_id' => $model->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $this->view->title = 'Chi tiết đơn hàng #' . $model->code . ' - ' . Constant::STATUS_ORDER[$model->status];
        return $this->render('view', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatus($id) {
        $model = Order::findOne(['code' => $id]);
        if (!$model or empty($_GET['key'])) {
            throw new NotFoundHttpException('This page does not exist in the system.');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $product_order = ProductOrder::find()->where(['order_id' => $model->id])->all();
            foreach ($product_order as $value) {
                Yii::$app->db->createCommand()->update('product_order', ['status' => $model->status], 'id=' . $value->id)->execute();
            }
            Yii::$app->session->setFlash('success', 'Bạn đã chuyển đơn hàng #' . $model->code . ' sang trạng thái ' . Constant::STATUS_ORDER[$model->status] . ' thành công');
            return $this->redirect(['index']);
        }
        $this->view->title = 'Chi tiết đơn hàng #' . $model->code . ' - ' . Constant::STATUS_ORDER[$model->status];
        return $this->render('status', [
                    'model' => $model,
                    'key' => $_GET['key'],
        ]);
    }

    public function actionDoaction() {
        if (!empty($_POST['selection']) && !empty($_POST['action'])) {
            foreach ($_POST['selection'] as $value) {
                $this->findModel($value)->delete();
            }
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Delete success'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app', 'Delete error'));
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
