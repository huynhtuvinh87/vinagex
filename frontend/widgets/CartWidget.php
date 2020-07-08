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

class CartWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $count = Cart::find()->where(['actor' => Yii::$app->user->id])->count();
        return $this->render('cart', ['count' => $count]);
    }

}
