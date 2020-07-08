<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use common\components\Constant;

class ImageController extends \backend\components\BackendController {

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
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Thông tin mới về sản phẩm: ' . $product['title'];
        return $this->render('index', ['dataProvider' => $dataProvider, 'product' => $product]);
    }

    public function actionAll($id) {
        if (!empty($_POST['selection'])) {
            if ($_POST['action'] == "delete") {
                foreach ($_POST['selection'] as $value) {
                    Yii::$app->mongodb->getCollection('product_image')->remove(['_id' => $value]);
                }
                Yii::$app->session->setFlash('success', 'Bạn đã xoá thành công');
            } elseif ($_POST['action'] == "active") {
                foreach ($_POST['selection'] as $value) {
                    Yii::$app->mongodb->getCollection('product_image')->update(['_id' => $value], ['$set' => ['status' => Constant::STATUS_ACTIVE]]);
                }
                Yii::$app->session->setFlash('success', 'Bạn đã duyệt thành công');
            } else {
                foreach ($_POST['selection'] as $value) {
                    Yii::$app->mongodb->getCollection('product_image')->update(['_id' => $value], ['$set' => ['status' => Constant::STATUS_CANCEL]]);
                }
                Yii::$app->session->setFlash('success', 'Bạn đã từ chối thành công');
            }
        } else {
            Yii::$app->session->setFlash('success', 'Bạn chưa chọn mục nào');
        }
        return $this->redirect(['index', 'id' => $id]);
    }

    public function actionDelete($id) {
        $query = (new Query)->from('product_image')->where(['_id' => $id])->one();
        Yii::$app->mongodb->getCollection('product_image')->remove(['_id' => $id]);
        Yii::$app->session->setFlash('success', 'Bạn đã xoá thành công');
        return $this->redirect(['index', 'id' => $query['product']['id']]);
    }

    public function actionActive($id) {
        $query = (new Query)->from('product_image')->where(['_id' => $id])->one();
        Yii::$app->mongodb->getCollection('product_image')->update(['_id' => $id], ['$set' => ['status' => Constant::STATUS_ACTIVE]]);
        Yii::$app->session->setFlash('success', 'Bạn đã duyệt thành công');
        return $this->redirect(['index', 'id' => $query['product']['id']]);
    }

    public function actionCancel($id) {
        $query = (new Query)->from('product_image')->where(['_id' => $id])->one();
        Yii::$app->mongodb->getCollection('product_image')->update(['_id' => $id], ['$set' => ['status' => Constant::STATUS_CANCEL]]);
        Yii::$app->session->setFlash('success', 'Bạn đã từ chối thành công');
        return $this->redirect(['index', 'id' => $query['product']['id']]);
    }

    public function actionView($id) {
        $model = (new Query)->from('product_image')->where(['_id' => $id])->one();
        return $this->renderAjax('view', ['model' => $model]);
    }

}
