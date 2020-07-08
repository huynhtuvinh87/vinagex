<?php

namespace console\controllers;

use yii\console\Controller;
use common\components\Constant;
use yii\mongodb\Query;

class ProductController extends Controller {

    public function actionStatus() {
        $query = (new Query)->from("product")->where(['<=', 'time_end', date('Y-m-d', time())])->all();
        var_dump($query); exit;
        if (!empty($query)) {
            foreach ($query as $key => $value) {
                \Yii::$app->mongodb->getCollection('product')->update(['_id' => (string) $value['_id']], ['$set' => [
                        'status' => Constant::STATUS_BLOCK
                ]]);
            }
        }
    }

}
