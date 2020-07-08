<?php

namespace console\controllers;

use yii\console\Controller;
use yii\mongodb\Query;

class SendmailController extends Controller {

    public function actionIndex() {
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
