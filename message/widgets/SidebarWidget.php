<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace seller\widgets;

use Yii;
use yii\base\Widget;
use common\models\Product;
use common\models\SellerOrder;
use common\components\Constant;

class SidebarWidget extends Widget {

    public $today;

    public function init() {
        $time = new \DateTime('now');
        $this->today = $time->format('Y-m-d');
    }

    public function run() {
        $cpp = Product::find()->where(['user_id' => \Yii::$app->user->id, 'status' => Constant::STATUS_PENDING])->count();
        $cpa = Product::find()->where(['user_id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ACTIVE])->count();
        $cs = Product::find()->where(['user_id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ACTIVE])->andWhere(['<=', 'time_begin', $this->today])->andWhere(['>=', 'time_end', $this->today])->count();
        $cto = Product::find()->where(['user_id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ACTIVE])->andWhere(['<', 'time_end', $this->today])->count();
        $order_pending = SellerOrder::find()->where(['seller_id' => \Yii::$app->user->id, 'status' => Constant::STATUS_PENDING])->count();
        $order_sending = SellerOrder::find()->where(['seller_id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ORDER_DGH])->count();
        $order_complete = SellerOrder::find()->where(['seller_id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ORDER_GHTC])->count();
        return $this->render('sidebar', ['cpp' => $cpp, 'cpa' => $cpa, 'cs' => $cs, 'cto' => $cto, 'order_pending' => $order_pending, 'order_sending' => $order_sending, 'order_complete' => $order_complete]);
    }

}
