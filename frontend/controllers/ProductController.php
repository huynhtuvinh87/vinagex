<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use frontend\models\ProductFilter;
use common\models\Review;
use yii\data\ActiveDataProvider;
use common\components\Constant;
use frontend\models\CommentForm;
use common\models\Comment;
use yii\web\NotFoundHttpException;
use common\models\Wishlist;
use common\models\Setting;
use frontend\storage\SellerItem;
use common\models\Report;
use yii\mongodb\Query;
use frontend\controllers\FrontendController;

class ProductController extends FrontendController {

    public $_setting;

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action) {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function init() {
        parent::init();
        $this->_setting = Setting::findOne(['key' => 'config']);
    }

    public function actionIndex() {
        $params = Yii::$app->request->getQueryParams();
        $fillter = new ProductFilter(['params' => $params]);
        $dataProvider = $fillter->fillter($params);
        $this->view->title = Yii::t('frontend', 'Danh sách sản phẩm');

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionInfo($id) {
        $product = (new Query)->from('product')->where(['_id' => $id])->one();
        $product_image = (new Query)->from('product_image')->where(['product.id' => $id, 'status' => Constant::STATUS_ACTIVE])->all();
        if (!$product_image) {
            return $this->redirect(['/' . $product['slug'] . '-' . $id]);
        }
        $this->view->title = Yii::t('frontend', 'Thông tin mới nhất về {title}', ['title' => \Yii::t('product', $product['title'])]);
        return $this->render('info', ['product' => $product, 'product_image' => $product_image]);
    }

    public function actionView($id) {
        $model = Product::active()->andWhere(['_id' => $id])->one();
        if ($model == null) {
            return $this->redirect(['/']);
        }

        $review = new Review();
        $comment = new CommentForm();
        $dataProviderReview = new ActiveDataProvider([
            'query' => Review::find()->where(['product.id' => $model->id, 'status' => Constant::STATUS_ACTIVE]),
            'pagination' => [
                'defaultPageSize' => 10
            ],
        ]);
        $query_comment = Comment::find()->andWhere(['product.id' => $model->id, 'status' => Comment::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC]);
        $dataProviderComment = new ActiveDataProvider([
            'query' => $query_comment,
            'pagination' => [
                'defaultPageSize' => 10
            ],
        ]);
        $product_recent = Product::active()->andWhere(['not in', '_id', $id])->andWhere(['product_type.id' => [$model->product_type['id']]])->limit(10)->all();
        $product_seller = Product::active()->andWhere(['owner.id' => $model->owner['id']])->andWhere(['not in', '_id', $id])->limit(5)->all();
        $buyer = (new Query)->from('order')->where(['product.id' => $id, 'status' => Constant::STATUS_ORDER_FINISH])->all();
        $wishlist = (new Query)->from('wishlist')->where(['user_id' => \Yii::$app->user->id, 'product_id' => $model->id])->one();
        $seller = (new Query)->from('user')->where(['_id' => $model->owner['id']])->one();
        return $this->render('view', [
                    'model' => $model,
                    'seller' => new SellerItem($seller),
                    'product_recent' => $product_recent,
                    'product_seller' => $product_seller,
                    'review' => $review,
                    'dataProviderReview' => $dataProviderReview,
                    'dataProviderComment' => $dataProviderComment,
                    'comment' => $comment,
                    'query_comment' => $query_comment,
                    'buyer' => $buyer,
                    'wishlist' => $wishlist
        ]);
    }

    public function actionPreview($id) {

        $model = Product::findOne($id);
        if (Yii::$app->user->isGuest or ( !in_array(Yii::$app->user->identity->role, ['seller', 'admin', 'superadmin']))) {
            return $this->redirect(['/']);
        }
        if ($model == null) {
            return $this->redirect(['/']);
        }
        $product_recent = Product::active()->andWhere(['not in', '_id', $id])->andWhere(['product_type.id' => [$model->product_type['id']]])->limit(10)->all();
        $product_seller = Product::active()->andWhere(['owner.id' => $model->owner['id']])->andWhere(['not in', '_id', $id])->limit(5)->all();
        $buyer = (new Query)->from('order')->where(['product.id' => $id, 'status' => Constant::STATUS_ORDER_FINISH])->all();
        $seller = (new Query)->from('user')->where(['_id' => $model->owner['id']])->one();
        return $this->render('preview', [
                    'model' => $model,
                    'seller' => new SellerItem($seller),
                    'product_recent' => $product_recent,
                    'product_seller' => $product_seller,
                    'buyer' => $buyer
        ]);
    }

    public function actionType($id) {
        $model = Product::active()->andWhere(['_id' => $id])->one();
        return $this->renderAjax('view', [
                    'model' => $model
        ]);
    }

    public function actionSave($id) {
        if ($model = Product::findOne($id)) {
            if (Yii::$app->user->isGuest) {
                return $this->redirect(['/user/login?redirect=' . Constant::redirect('/' . $model->slug . '-' . $model->d)]);
            }
            $data = [
                'actor' => Yii::$app->user->id,
                'product' => [
                    'id' => $model->id,
                    'title' => $model->title,
                    'slug' => $model->slug,
                    'image' => $model->images[0]['size_300'],
                    'owner' => $model->owner,
                    'province' => $model->province,
                    'quantity' => $model->quantity,
                    'unit_of_calculation' => $model->unit_of_calculation['use'],
                    'time_begin' => $model->time_begin,
                    'time_end' => $model->time_end
                ],
                'created_at' => time(),
                'updated_at' => time()
            ];
            if (!Wishlist::findOne(['product.id' => $model->id, 'actor' => (int) Yii::$app->user->id])) {
                Yii::$app->mongodb->getCollection('wishlist')->insert($data);
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Bạn đã lưu sản phẩm thành công.'));
            }
            return $this->redirect(['/' . $model->slug . '-' . $model->id]);
        }
        return $this->redirect(['/' . $product['slug'] . '-' . $id]);
    }

    public function actionReport($id) {
        $model = new Report();
        $product = (new Query)->from('product')->where(['_id' => $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $array = [];
            foreach ($model->reason as $value) {
                $array[] = $model->status()[$value];
            }

            $id = Yii::$app->mongodb->getCollection('report')->insert([
                'product' => [
                    'id' => $id,
                    'title' => $product['title'],
                    'slug' => $product['slug']
                ],
                'owner' => $product['owner'],
                'reason' => $array,
                'description' => $model->description,
                'email' => $model->email,
                'phone' => $model->phone,
                'status' => 0,
                'type' => 'product',
                'created_at' => time(),
                'updated_at' => time()
            ]);
            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'admin',
                'content' => 'Sản phẩm ' . $product['title'] . ' bị báo cáo bởi ' . $model->email,
                'url' => Yii::$app->setting->get('siteurl_backend') . '/report/index?id=' . $id,
                'status' => 0,
                'created_at' => time()
            ]);
        } else {
            return $this->renderAjax('report', [
                        'model' => $model
            ]);
        }
    }

    public function actionReportimage($id) {
        $model = new Report();
        $product = (new Query)->from('product')->where(['_id' => $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->reason)) {
                foreach ($model->reason as $value) {
                    $array[] = $model->productImage()[$value];
                }
            } else {
                return Yii::t('frontend', "Bạn chưa chọn nội dung báo cáo!");
            }
            $id = Yii::$app->mongodb->getCollection('report')->insert([
                'product' => [
                    'id' => $id,
                    'title' => $product['title'],
                    'slug' => $product['slug']
                ],
                'owner' => $product['owner'],
                'reason' => $array,
                'description' => $model->description,
                'email' => $model->email,
                'phone' => $model->phone,
                'status' => 0,
                'type' => 'product_image',
                'created_at' => time(),
                'updated_at' => time()
            ]);
            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'admin',
                'content' => 'Hình ảnh sản phẩm ' . $product['title'] . ' bị báo cáo bởi ' . $model->email,
                'url' => Yii::$app->setting->get('siteurl_backend') . '/report/index?id=' . $id,
                'status' => 0,
                'created_at' => time()
            ]);
            return Yii::t('frontend', "Bạn đã báo cáo thành công.");
        } else {
            return $this->renderAjax('report_image', [
                        'model' => $model
            ]);
        }
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
