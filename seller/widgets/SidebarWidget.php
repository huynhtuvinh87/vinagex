<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace seller\widgets;

use yii\base\Widget;
use common\models\Product;
use common\components\Constant;
use yii\mongodb\Query;

class SidebarWidget extends Widget {

    public function run() {
        $cpp = Product::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_NOACTIVE])->count();
        $cpa = Product::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ACTIVE])->count();
        $cpb = Product::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_BLOCK])->count();
        $cpc = Product::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_CANCEL])->count();
        $count_order = (new Query)->from("order")->where(['owner.id' => \Yii::$app->user->id])->count();
        $comment = (new Query)->from("comment")->where(['product.owner.id' => \Yii::$app->user->id])->count();
        return $this->render('sidebar', [
                    'cpp' => $cpp,
                    'cpa' => $cpa,
                    'cpb' => $cpb,
                    'cpc' => $cpc,
                    'count_order' => $count_order,
                    'comment' => $comment
        ]);
    }

}
