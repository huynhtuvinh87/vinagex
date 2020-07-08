<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\Order;
use common\models\searchs\OrderSearch;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\Product;
use common\components\Constant;
use backend\components\BackendController;
use yii\filters\VerbFilter;
use common\models\Statics;
use common\models\StaticItem;
use yii\mongodb\Query;

class OrderController extends BackendController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $search = new OrderSearch();
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        return $this->render('list', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

    public function actionPending() {

        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['status' => Constant::STATUS_ORDER_PENDING])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Đơn hàng mới';
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    public function actionSending() {

        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['status' => Constant::STATUS_ORDER_SENDING])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Đơn hàng đang giao';
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    public function actionUnsuccessful() {

        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['status' => Constant::STATUS_ORDER_UNSUCCESSFUL])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Đơn hàng không thành công';
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    public function actionFinish() {

        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['status' => Constant::STATUS_ORDER_FINISH])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Đơn hàng thành công';
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    public function actionBlock() {

        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['status' => Constant::STATUS_ORDER_BLOCK])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Đơn hàng đã hủy';
        return $this->render('list', ['dataProvider' => $dataProvider]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = Order::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
        return $this->renderAjax('view', [
                    'model' => $model
        ]);
    }

    public function actionReason($id) {
        $model = Order::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
        return $this->renderAjax('reason', [
                    'model' => $model
        ]);
    }

    // public function actionStatus($id) {
    //     $model = (new Query)->from('product_order')->where(['order.id' => $id])->all();
    //     return $this->renderAjax('status', ['model' => $model]);
    //     if (!empty($model)) {
    //         $model->status = Constant::STATUS_ORDER_GHTC;
    //         if ($model->save()) {
    //             foreach ($model->products as $value) {
    //                 $product = Product::findOne($value['id']);
    //                 $static = Statics::find()->where(['product_type.id' => $product['product_type']['id']])->one();
    //                 if (!empty($static)) {
    //                     $static->quantity = $static->quantity + (int) $value['quantity'];
    //                     $static->save();
    //                     $static_id = $static->id;
    //                 } else {
    //                     $static_id = Yii::$app->mongodb->getCollection('statics')->insert([
    //                         'owner' => $value['owner'],
    //                         'quantity' => (int) $value['quantity'],
    //                         'price' => (int) $value['price'],
    //                         'category' => $product->category,
    //                         'product_type' => $product->product_type,
    //                         'unit' => $product->unit
    //                     ]);
    //                 }
    //                 $staticItem = StaticItem::find()->where(['static_id' => $static_id])->one();
    //                 if (!empty($staticItem)) {
    //                     $staticItem->quantity = $staticItem->quantity + (int) $value['quantity'];
    //                     $staticItem->save();
    //                 } else {
    //                     Yii::$app->mongodb->getCollection('static_item')->insert([
    //                         'static_id' => (string) $static_id,
    //                         'quantity' => (int) $value['quantity'],
    //                         'province' => $value['province'],
    //                         'unit' => $product->unit,
    //                         'date' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s")
    //                     ]);
    //                 }
    //                 Yii::$app->mongodb->getCollection('payment_history')->insert([
    //                     'order' => [
    //                         'actor' => (int) $model->actor,
    //                         'name' => $model->name,
    //                         'address' => $model->address
    //                     ],
    //                     'owner' => $value['owner'],
    //                     'category' => $product['category'],
    //                     'product_type' => $product['product_type'],
    //                     'quantity' => (int) $value['quantity'],
    //                     'province' => $value['province'],
    //                     'product' => [
    //                         'id' => $product->id,
    //                         'title' => $product->title,
    //                         'slug' => $product->slug
    //                     ],
    //                     'date' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s")
    //                 ]);
    //             }
    //         }
    //         return $this->redirect(['sending']);
    //     }
    // }

    public function actionStatus($id) {
        $model = (new Query)->from('order')->where(['_id' => $id])->one();
        if (!empty($model)) {
            Yii::$app->mongodb->getCollection('order')->update(['_id'=>$id],['status'=> Constant::STATUS_ORDER_DGH]);
            Yii::$app->session->setFlash('success', "Đơn hàng đang được giao.");
            return $this->redirect(['pending']);
            }
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
