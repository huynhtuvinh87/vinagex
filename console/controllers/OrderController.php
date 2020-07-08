<?php

namespace console\controllers;

use yii\console\Controller;
use common\components\Constant;
use yii\mongodb\Query;

class OrderController extends Controller {

    public function actionStatus() {
        $query = (new Query)->from("order")->where(['status' => Constant::STATUS_ORDER_PENDING])->andWhere(['<=', 'created_at', time() - 24 * 3600])->all();
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                \Yii::$app->mongodb->getCollection('order')->update(['_id' => (string) $value['_id']], ['$set' => [
                        'status' => Constant::STATUS_ORDER_BLOCK
                ]]);

                   Yii::$app->mongodb->getCollection('notification')->insert([
                        'type' => 'seller',
                        'owner' => $value['owner']['id'],
                        'content' => 'Đơn hàng #<b>'.$value['code'] . '</b> đã tự động hủy sau 24h.',
                        'url' => '/order/filter?keywords='.(int)$value['code'],
                        'status' => 0,
                        'created_at' => time()
                    ]);
            }
        }
    }

}
