<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\Product;
use yii\web\NotFoundHttpException;
use backend\components\BackendController;
use common\components\Constant;
use common\models\ProductProvince;

class StatusController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    public function actionActive($id) {
        $model = $this->findModel($id);
        Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], ['$set' => ["status" => Constant::STATUS_ACTIVE]]);
        Yii::$app->session->setFlash('success', 'Bạn đã kích hoạt sản phẩm thành công.');
        return $this->redirect(['product/pending']);
    }

    public function actionBlock($id) {
        $model = $this->findModel($id);
        Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], ['$set' => ["status" => Constant::STATUS_BLOCK]]);
        Yii::$app->session->setFlash('success', 'Bạn đã đóng sản phẩm thành công.');
        return $this->redirect(['product/block']);
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
