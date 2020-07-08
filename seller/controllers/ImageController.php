<?php

namespace seller\controllers;

use Yii;
use common\models\Product;
use seller\models\ProductForm;
use seller\models\ProductImageForm;
use common\components\Constant;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

class ImageController extends ManagerController {

    public $today;

    public function init() {
        parent::init();
        $time = new \DateTime('now');
        $this->today = $time->format('Y-m-d');
    }

    public function actionIndex($id) {
        $product = (new Query)->from('product')->where(['_id' => $id])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query)->from('product_image')->where(['product.id' => $id]),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->view->title = 'Cập nhật mới cho sản phẩm: ' . $product['title'];
        return $this->render('index', ['dataProvider' => $dataProvider, 'product' => $product]);
    }

    public function actionUpload($id) {
        $product = (new Query)->from('product')->where(['_id' => $id])->one();
        $model = new ProductImageForm(['product_id' => $id]);
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->content)) {
                Yii::$app->mongodb->getCollection('product_image')->insert([
                    'product' => [
                        'id' => $id,
                        'title' => $product['title'],
                        'slug' => $product['slug']
                    ],
                    'content' => $model->content,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'status' => Constant::STATUS_NOACTIVE
                ]);

                Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], ['$set' => [
                        'show_process' => Constant::STATUS_NOACTIVE,
                ]]);
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'admin',
                    'content' => '<b>' . Yii::$app->user->identity->garden_name . '</b> vừa tạo mới về thông tin sản phẩm.',
                    'url' => Yii::$app->setting->get('siteurl_backend') . '/product/verified?ProductSearch[id]=' . $id,
                    'status' => 0,
                    'created_at' => time()
                ]);
            }
            return $this->redirect(['index', 'id' => $id]);
        }

        return $this->renderAjax('upload', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $query = (new Query)->from('product_image')->where(['_id' => $id])->one();
        $model = new ProductImageForm(['product_id' => $query['product']['id']]);
        $model->content = $query['content'];
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->content)) {
                Yii::$app->mongodb->getCollection('product_image')->update(['_id' => $id], ['$set' => [
                        'content' => $model->content,
                        'status' => Constant::STATUS_NOACTIVE,
                        'updated_at' => time(),
                ]]);
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'admin',
                    'content' => '<b>' . Yii::$app->user->identity->garden_name . '</b> vừa cập nhật về thông tin sản phẩm.',
                    'url' => Yii::$app->setting->get('siteurl_backend') . '/product/verified?ProductSearch[id]=' . $query['product']['id'],
                    'status' => 0,
                    'created_at' => time()
                ]);
            }
            return $this->redirect(['index', 'id' => $query['product']['id']]);
        }
        return $this->renderAjax('upload', ['model' => $model]);
    }

    public function actionDelete($id) {
        $query = (new Query)->from('product_image')->where(['_id' => $id])->one();
        Yii::$app->mongodb->getCollection('product_image')->remove(['_id' => $id]);
        $count = (new Query)->from('product_image')->where(['product.id' => $query['product']['id']])->count();
        Yii::$app->session->setFlash('success', 'Xóa thành công');
        return $this->redirect(['index', 'id' => $query['product']['id']]);
    }

    public function actionDeleteall($id) {
        if (!empty($_POST['selection'])) {
            foreach ($_POST['selection'] as $value) {
                Yii::$app->mongodb->getCollection('product_image')->remove(['_id' => $value]);
            }
            Yii::$app->session->setFlash('success', 'Xóa thành công');
        } else {
            Yii::$app->session->setFlash('success', 'Bạn chưa chọn mục nào');
        }
        return $this->redirect(['index', 'id' => $id]);
    }

}
