<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\District;
use yii\mongodb\Query;
use common\components\Constant;

class AjaxController extends Controller {

    public function init() {
        parent::init();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionCommentdelete() {
        $query = (new Query)->from('comment')->where(['_id' => $_POST['id']])->one();
        unset($query['answers'][(int) $_POST['key']]);
        Yii::$app->mongodb->getCollection('comment')->update(['_id' => $_POST['id']], ['$set' => [
                'count_answer' => (int) $query['count_answer'] - 1,
                'answers' => $query['answers']
        ]]);
        return TRUE;
    }

    public function actionCommentstatus() {
        Yii::$app->mongodb->getCollection('comment')->update(['_id' => $_POST['comment_id']], ['$set' => [
                'answers.' . $_POST['key'] . '.status' => 2
        ]]);
        return TRUE;
    }

    public function actionDistrict() {
        $model = District::find()->select('id,city_id,name')->where(['city_id' => $_POST['id']])->asArray()->all();
        return $model;
    }

    public function actionOrderstatus() {
        $query = (new Query)->from('product_order')->where(['_id' => $_POST['id']])->one();
        Yii::$app->mongodb->getCollection('product_order')->update(['_id' => $_POST['id']], [
            'status' => (int) Constant::STATUS_ORDER_GHTC
        ]);
        $count = (new Query)->from('product_order')->where(['_id' => $_POST['id']])->andWhere(['<=', 'status', Constant::STATUS_ORDER_DGH])->count();

        if ($count == 0) {
            Yii::$app->mongodb->getCollection('order')->update(['_id' => $query['order']['id']], [
                'status' => (int) Constant::STATUS_ORDER_GHTC
            ]);
        }
//        $product = Product::findOne($product_order['product_id']);
//        $static = Statics::find()->where(['product_type.id' => $product['product_type']['id']])->one();
//        if (!empty($static)) {
//            $static->quantity = $static->quantity + (int) $product_order['quantity'];
//            $static->save();
//            $static_id = $static->id;
//        } else {
//            $static_id = Yii::$app->mongodb->getCollection('statics')->insert([
//                'owner' => $product_order['owner'],
//                'quantity' => (int) $product_order['quantity'],
//                'price' => (int) $product_order['price'],
//                'category' => $product->category,
//                'product_type' => $product->product_type,
//                'unit' => $product->unit
//            ]);
//        }
//        $staticItem = StaticItem::find()->where(['static_id' => $static_id])->one();
//        if (!empty($staticItem)) {
//            $staticItem->quantity = $staticItem->quantity + (int) $product_order['quantity'];
//            $staticItem->save();
//        } else {
//            Yii::$app->mongodb->getCollection('static_item')->insert([
//                'static_id' => (string) $static_id,
//                'quantity' => (int) $product_order['quantity'],
//                'province' => $value['province'],
//                'unit' => $product->unit,
//                'date' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s")
//            ]);
//        }
//        Yii::$app->mongodb->getCollection('payment_history')->insert([
//            'order' => [
//                'actor' => (int) $model->actor,
//                'name' => $model->name,
//                'address' => $model->address
//            ],
//            'owner' => $value['owner'],
//            'category' => $product['category'],
//            'product_type' => $product['product_type'],
//            'quantity' => (int) $value['quantity'],
//            'province' => $value['province'],
//            'product' => [
//                'id' => $product->id,
//                'title' => $product->title,
//                'slug' => $product->slug
//            ],
//            'date' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s")
//        ]);
    }



}
