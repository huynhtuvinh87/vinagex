<?php

namespace seller\controllers;

use Yii;
use common\models\Product;
use seller\models\ProductForm;
use seller\models\ProductFilter;
use common\components\Constant;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;

class ProductController extends ManagerController {

    public $today;

    public function init() {
        parent::init();
        $time = new \DateTime('now');
        $this->today = $time->format('Y-m-d');
    }

    public function actionFilter() {
        $filter = new ProductFilter();
        $dataProvider = $filter->fillter(Yii::$app->request->queryParams);
        $this->view->title = 'Sản phẩm của bạn';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionIndex() {

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['owner.id' => \Yii::$app->user->id])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->view->title = 'Danh sách sản phẩm';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionPending() {

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_NOACTIVE])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 36,
            ],
        ]);

        $this->view->title = 'Sản phẩm chờ duyệt';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionVerified() {

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ACTIVE])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 36,
            ],
        ]);

        $this->view->title = 'Sản phẩm đã duyệt';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionBlock() {

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_BLOCK])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 36,
            ],
        ]);

        $this->view->title = 'Sản phẩm hết hàng ';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCanceled() {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_CANCEL])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 36,
            ],
        ]);

        $this->view->title = 'Sản phẩm bị hủy bỏ ';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCancel($id) {
        $model = Product::findOne($id);
        return $this->renderAjax('_cancel', ['model' => $model]);
    }

    public function actionUnblock($id) {
        $product = Product::findOne($id);
        if (!empty($product)) {
            $order = (new Query)->from('order')->orWhere(['status' => Constant::STATUS_ORDER_SENDING])->orWhere(['status' => Constant::STATUS_ORDER_PENDING])->andWhere(['product.id' => $id])->count();
            if ($order > 0) {
                Yii::$app->session->setFlash('danger', 'Sản phẩm này đang có đơn hàng ở trạng thái đang chờ xử lý hoặc đang giao hàng.Vui lòng xử lý hết đơn hàng của sản phẩm.');
                return $this->redirect(['block']);
            } else {
                $data['status'] = Constant::STATUS_ACTIVE;
                if ($product->classify) {
                    foreach ($product->classify as $key => $value) {
                        $data['classify.' . $key . '.quantity_purchase'] = (int) 0;
                        $data['classify.' . $key . '.status'] = (int) 1;
                    }
                } else {
                    $data['quantity_purchase'] = (int) 0;
                }
                Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], ['$set' => $data]);
                Yii::$app->session->setFlash('success', 'Xử lý thành công.');
                return $this->redirect(['block']);
            }
        }
        return $this->redirect(['block']);
    }

    public function actionEnblock($id) {
        $product = Product::findOne($id);
        if (!empty($product)) {
            $order = (new Query)->from('order')->orWhere(['status' => Constant::STATUS_ORDER_SENDING])->orWhere(['status' => Constant::STATUS_ORDER_PENDING])->andWhere(['product.id' => $id])->count();
            if ($order > 0) {
                Yii::$app->session->setFlash('danger', 'Sản phẩm này đang có đơn hàng ở trạng thái đang chờ xử lý hoặc đang giao hàng nên bạn không thể để hết hàng.');
                return $this->redirect(['verified']);
            } else {
                Yii::$app->mongodb->getCollection('product')->update(['_id' => $id], ['status' => Constant::STATUS_BLOCK]);
                Yii::$app->session->setFlash('success', 'Xử lý thành công.');
                return $this->redirect(['verified']);
            }
        }
        return $this->redirect(['verified']);
    }

    public function actionCreate() {
        if (Yii::$app->user->identity->public == 0) {
            Yii::$app->session->setFlash('warning', 'Vui lòng cập nhật thông tin bên dưới, chúng tôi sẽ xác minh ngay lập tức và bạn có thể đăng bán sản phẩm.');
            return $this->redirect(['seller/index']);
        }
        $model = new ProductForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Bạn đã thêm sản phẩm thành công!');
            }
            return $this->redirect(['pending']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $model = new ProductForm(['id' => $id]);
        if (Yii::$app->user->id == $model->owner['id']) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $product = $this->findModel($id);
                return $this->redirect(['update', 'id' => $id]);
            }

            return $this->render('update', ['model' => $model]);
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionDelete($id) {
        $model = Product::findOne($id);
        if ($model) {
            if (Yii::$app->user->id == $model->owner['id']) {
                $order = (new Query)->from('order')->orWhere(['status' => Constant::STATUS_ORDER_SENDING])->orWhere(['status' => Constant::STATUS_ORDER_PENDING])->andWhere(['product.id' => $id])->count();
                if ($order > 0) {
                    \Yii::$app->getSession()->setFlash('danger', 'Sản phẩm này đang có đơn hàng ở trạng thái đang chờ xử lý hoặc đang giao hàng nên bạn không thể xóa.');
                } else {
                    $model->delete();
                    \Yii::$app->getSession()->setFlash('success', 'Bạn đã xóa sản phẩm thành công');
                }
                if ($model->status == Constant::STATUS_NOACTIVE) {
                    $link = 'pending';
                } elseif ($model->status == Constant::STATUS_ACTIVE) {
                    $link = 'verified';
                } elseif ($model->status == Constant::STATUS_BLOCK) {
                    $link = 'block';
                } elseif ($model->status == Constant::STATUS_CANCEL) {
                    $link = 'canceled';
                }
                return $this->redirect([$link]);
            }
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

    public function actionView($id) {
        $model = Product::findOne($id);

        return $this->render('view', ['model' => $model]);
    }

    protected function validatePrice($prev, $next) {
        if ($next < $prev) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne(['_id' => $id, 'owner.id' => \Yii::$app->user->id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
