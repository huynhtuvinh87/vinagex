<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace forum\widgets;

use Yii;
use yii\base\Widget;
use frontend\models\Cart;
use common\models\Category;
use common\models\Province;
use common\models\Page;

class FooterWidget extends Widget {

    public $layout;

    public function init() {
        
    }

    public function run() {
        $count = Cart::find()->where(['actor' => Yii::$app->user->id])->count();
        $category = Category::find()->orderBy(['order' => SORT_ASC])->all();
        $province = Province::find()->all();
        $info = Page::find()->where(['widget'=>Page::WIDGET_INFO])->andWhere(['status'=>Page::STATUS_PUBLIC])->all();
        $cooperate = Page::find()->where(['widget'=>Page::WIDGET_COOPERATE])->andWhere(['status'=>Page::STATUS_PUBLIC])->all();
        $support_buyer = Page::find()->where(['widget'=>Page::WIDGET_SUPPORT_BUYER])->andWhere(['status'=>Page::STATUS_PUBLIC])->all();
        $support_seller = Page::find()->where(['widget'=>Page::WIDGET_SUPPORT_SELLER])->andWhere(['status'=>Page::STATUS_PUBLIC])->all();

        $address = Page::find()->where(['widget'=>Page::WIDGET_ADDRESS])->andWhere(['status'=>Page::STATUS_PUBLIC])->all();
        
        return $this->render('footer', [
        	'count' => $count, 
        	'category' => $category, 
        	'province' => $province, 
        	'layout' => $this->layout,
        	'info' => $info,
        	'cooperate' => $cooperate,
        	'support_buyer' => $support_buyer,
            'support_seller' => $support_seller,
        	'address' => $address,
        ]);
    }

}
