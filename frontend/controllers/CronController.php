<?php

namespace frontend\controllers;

use yii\console\Controller;
use common\components\Constant;
use yii\mongodb\Query;

class CronController extends Controller {

    public function actionProduct() {
        $query = (new Query)->from("product")->where(['<=', 'time_end', date('Y-m-d', time())])->all();
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                \Yii::$app->mongodb->getCollection('product')->update(['_id' => (string) $value['_id']], ['$set' => [
                        'status' => Constant::STATUS_BLOCK
                ]]);
            }
        }
    }

    public function actionOrder() {
        $query = (new Query)->from("order")->where(['status' => Constant::STATUS_ORDER_PENDING])->andWhere(['<=', 'created_at', time() - 24 * 3600])->all();
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                \Yii::$app->mongodb->getCollection('order')->update(['_id' => (string) $value['_id']], ['$set' => [
                        'status' => Constant::STATUS_ORDER_BLOCK
                ]]);

                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'seller',
                    'owner' => $value['owner']['id'],
                    'content' => 'Đơn hàng #<b>' . $value['code'] . '</b> đã tự động hủy sau 24h.',
                    'url' => '/order/filter?keywords=' . (int) $value['code'],
                    'status' => 0,
                    'created_at' => time()
                ]);
            }
        }
    }

    public function actionSendmail() {
        $query = (new Query)->from("mail")->all();
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                if ($value['type'] == "invoice") {
                    \Yii::$app->sendmail->invoice($value['code'], $value['title']);
                } else if ($value['type'] == "order") {
                    \Yii::$app->sendmail->orderSeller($value['order_id'], $value['layout'], $value['title']);
                } else if ($value['type'] == "seller") {
                    \Yii::$app->sendmail->statusSeller($value['actor'], $value['layout'], $value['title']);
                } else {
                    \Yii::$app->sendmail->order($value['order_id'], $value['layout'], $value['title']);
                }
                \Yii::$app->mongodb->getCollection('mail')->remove(['_id' => (string) $value['_id']]);
            }
        }
    }

}
