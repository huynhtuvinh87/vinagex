<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use frontend\models\Cart;
use common\models\Province;
use common\models\Category;
use common\models\Notification;

class HeaderWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $cart = Cart::getUser()->all();
        $province = Province::find()->orderBy(['order'=>SORT_ASC])->all();
        $category = Category::find()->orderBy(['order' => SORT_ASC])->all();
        $notification = Notification::find()->where(['owner'=>\Yii::$app->user->id])->andWhere(['not in','type',['admin']])->limit(10)->orderBy(['created_at' => SORT_DESC])->all();
        $count_buyer = Notification::find()->where(['owner'=>\Yii::$app->user->id,'status'=>0])->andWhere(['not in','type',['admin']])->count();

        return $this->render('header', [
                    'cart' => $cart,
                    'province' => $province,
                    'category' => $category,
                    'notification' => $notification,
                    'count_buyer' => $count_buyer
        ]);
    }

}
