<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use common\models\Review;
use yii\data\ActiveDataProvider;
use common\components\Constant;
use yii\web\NotFoundHttpException;
use common\models\User;
use frontend\models\SellerFilter;
use yii\mongodb\Query;
use common\models\Order;
use frontend\controllers\FrontendController;

class SellerController extends FrontendController {

    public function actionIndex() {
        $params = Yii::$app->request->getQueryParams();
        $filter = new SellerFilter(['params' => $params]);
        $dataProvider = $filter->fillter($params);
        $this->view->title = Yii::t('frontend', 'Danh sách nhà vườn');
        $count_seller = User::find()->where(['role' => User::ROLE_SELLER, 'public' => User::PUBLIC_ACTIVE, 'status' => User::STATUS_ACTIVE])->count();
        return $this->render('index', ['dataProvider' => $dataProvider, 'count_seller' => $count_seller, 'filter' => $filter]);
    }

    public function actionView($id) {
         
        $model = User::findOne($id);
        if ($model == null) {
            return $this->redirect(['index']);
        }
        if (!empty($_GET['type'])) {
            switch ($_GET['type']) {
                case 'certification':
                    return $this->render('certification', ['model' => $model]);
                    break;
                case 'review':
                    $dataProviderReview = new ActiveDataProvider([
                        'query' => Review::find()->where(['owner.id' => $model->id, 'status' => Constant::STATUS_ACTIVE]),
                        'pagination' => [
                            'defaultPageSize' => 20
                        ],
                    ]);
                    return $this->render('review', ['model' => $model, 'dataProviderReview' => $dataProviderReview]);
                    break;
                case 'product':
                    $dataProviderProduct = new ActiveDataProvider([
                        'query' => Product::active()->andWhere(['owner.id' => $model->id])
                    ]);
                    return $this->render('product', ['model' => $model, 'dataProviderProduct' => $dataProviderProduct]);
                    break;
                case 'history':
                    $dataProviderHistory = new ActiveDataProvider([
                        'query' => Order::find()->where(['owner.id' => $model->id, 'status' => Constant::STATUS_ORDER_FINISH])->orderBy(['_id' => SORT_DESC]),
                        'pagination' => [
                            'defaultPageSize' => 20
                        ],
                    ]);
                    return $this->render('history', ['model' => $model, 'countHistory' => Order::find()->where(['owner.id' => $model->id, 'status' => Constant::STATUS_ORDER_FINISH])->count(), 'dataProviderHistory' => $dataProviderHistory]);
                    break;
                default:
                    $collection = Yii::$app->mongodb->getCollection('static');
                    $static = $collection->aggregate([
                        ['$match' => ['owner' => $model->id]],
                        [
                            '$group' => [
                                '_id' => ['product' => '$product'],
                                'totalQtt' => ['$sum' => '$quantity'],
                                'totalAmount' => ['$sum' => ['$multiply' => ['$quantity', '$price']]],
                                'count' => [
                                    '$sum' => 1
                                ],
                            ],
                        ],
                    ]);
                    $order_finish = (new Query)->from('order')->where(['owner.id' => $model->id])->all();
                    return $this->render('static', ['order_finish' => $order_finish, 'model' => $model, 'static' => $static]);
                    break;
            }
        }
        $dataProviderProduct = new ActiveDataProvider([
            'query' => Product::active()->andWhere(['owner.id' => $model->id])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'defaultPageSize' => 8
            ],
        ]);
        return $this->render('view', [
                    'model' => $model,
                    'dataProviderProduct' => $dataProviderProduct
        ]);
    }

    public function actionCertification($id) {
        $model = User::findOne(['owner' => (int) $id]);
        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Trang này không tồn tại trong hệ thống.'));
        }
        return $this->render('certification', ['model' => $model]);
    }

    public function actionReview($id) {
        $model = User::findOne(['owner' => (int) $id]);
        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('frontend', 'Trang này không tồn tại trong hệ thống.'));
        }
        return $this->render('certification', ['model' => $model]);
    }

    public function actionStatic($id) {
        $collection = Yii::$app->mongodb->getCollection('static');
        $static = $collection->aggregate([
            ['$match' => ['product.id' => $id]],
            [
                '$group' => [
                    '_id' => ['province' => '$province'],
                    'totalQtt' => ['$sum' => '$quantity'],
                    'totalAmount' => ['$sum' => ['$multiply' => ['$quantity', '$price']]],
                    'count' => [
                        '$sum' => 1
                    ],
                ],
            ],
        ]);
        return $this->renderAjax('staticItem', ['static' => $static]);
    }

    public function actionPaymenthistory($id) {
        $model = User::findOne($id);
        return $this->renderAjax('paymenthistory', ['model' => $model]);
    }

    public function actionAbout() {
        $this->layout = "seller";
        return $this->render('about');
    }

}
