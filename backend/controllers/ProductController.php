<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\Product;
use common\models\searchs\ProductSearch;
use yii\web\NotFoundHttpException;
use backend\components\BackendController;
use common\components\Constant;
use backend\models\ProductForm;
use yii\widgets\ActiveForm;
use yii\mongodb\Query;

class ProductController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionPending() {
        $search = new ProductSearch();
        $search->status = Constant::STATUS_NOACTIVE;
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        $this->view->title = 'Sản phẩm chưa duyệt';
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

    public function actionVerified() {
        $search = new ProductSearch();
        $search->status = Constant::STATUS_ACTIVE;
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        $this->view->title = 'Sản phẩm đã duyệt';
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

    public function actionBlock() {
        $search = new ProductSearch();
        $search->status = Constant::STATUS_BLOCK;
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        $this->view->title = 'Sản phẩm đã hết hàng';
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

    public function actionCanceled() {
        $search = new ProductSearch();
        $search->status = Constant::STATUS_CANCEL;
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        $this->view->title = 'Sản phẩm đã huỷ';
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

//    public function actionExcel() {
//        header('Content-Encoding: UTF-8');
//        header("Content-Type: text/csv; charset=utf-8");
//        header("Content-Disposition: attachment; filename=" . date('d-m-Y') . '-' . time() . '.csv');
//        header("Pragma: no-cache");
//        header("Expires: 0");
//
//        $header = array('Ten', 'Gia si', 'Gia ban', 'Link', 'Hinh anh');
//        $list = array();
//        array_push($list, $header);
//        $product = Product::find()->all();
//        foreach ($product as $data) {
//            $title = \Yii::$app->convert->unsigned($data->title);
//            if (!empty($data->price_fake)) {
//                $row = array(
//                    $title,
//                    $data->price_fake,
//                    $data->price,
//                    \Yii::$app->params['domain'] . '/' . $data->slug,
//                    $data->picture
//                );
//                array_push($list, $row);
//            }
//        }
//        $output = fopen("php://output", "w");
//        foreach ($list as $row) {
//            fputcsv($output, $row); // here you can change delimiter/enclosure
//        }
//        fclose($output);
//    }

    public function actionView($id) {
        $model = Product::findOne($id);
        if (Yii::$app->request->post()) {
            if ($model->status == Constant::STATUS_NOACTIVE) {
                Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], ['status' => Constant::STATUS_ACTIVE]);
                return $this->redirect(['pending']);
            }
            if ($model->status == Constant::STATUS_ACTIVE) {
                Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], ['status' => Constant::STATUS_BLOCK]);
                return $this->redirect(['block']);
            }
        }
        return $this->renderAjax('view', [
                    'model' => $model
        ]);
    }

    public function actionCancel($id) {
        $model = new ProductForm(['id' => $id]);
        $product = Product::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], [
                'status' => Constant::STATUS_CANCEL,
                'note_cancel' => $model->note_cancel
            ]);
            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'seller',
                'owner' => $product->owner['id'],
                'content' => 'Sản phẩm <b>' . $product->title . '</b> đã bị từ chối.',
                'url' => Yii::$app->setting->get('siteurl_seller') . '/product/filter?id=' . $product->id,
                'status' => 0,
                'created_at' => time()
            ]);

            \Yii::$app->getSession()->setFlash('success', 'Hủy thành công');
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('_cancel', ['model' => $model]);
    }

    public function actionStatus($id) {

        Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], [
            'status' => (int) $_GET['s']
        ]);

        $model = Product::findOne($id);

        if ($_GET['s'] == Constant::STATUS_ACTIVE) {

            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'seller',
                'owner' => $model->owner['id'],
                'content' => 'Sản phẩm <b>' . $model->title . '</b> đã được duyệt thành công.',
                'url' => Yii::$app->setting->get('siteurl_seller') . '/product/filter?id=' . $model->id,
                'status' => 0,
                'created_at' => time()
            ]);

            \Yii::$app->getSession()->setFlash('success', 'Bạn đã duyệt sản phẩm này thành công');
        } else {
            \Yii::$app->getSession()->setFlash('success', ' Bạn đã khoá sản phẩm thành công');
        }
        return $this->redirect(['pending']);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $order = (new Query)->from('order')->orWhere(['status' => Constant::STATUS_ORDER_SENDING])->orWhere(['status' => Constant::STATUS_ORDER_PENDING])->andWhere(['product.id' => $id])->count();
        if ($order > 0) {
            \Yii::$app->getSession()->setFlash('danger', 'Sản phẩm này vẫn còn đơn hàng đang xử lý và đơn hàng đang giao.');
            return $this->redirect(['canceled']);
        } else {
            $this->findModel($id)->delete();
            \Yii::$app->getSession()->setFlash('success', 'Bạn đã xóa sản phẩm thành công');
            return $this->redirect(['canceled']);
        }
    }

    public function actionImage($id) {
        $query = (new Query)->from('product_image')->where(['product.id' => $id])->all();
        if ($query) {
            return $this->renderAjax('image', ['model' => $query, 'product_id' => $id]);
        }
    }

    public function actionStatusimage($id) {
        Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], [
            'show_process' => (int) $_POST['status']
        ]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
