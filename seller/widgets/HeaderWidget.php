<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace seller\widgets;

use yii\base\Widget;
use common\components\Constant;
use yii\mongodb\Query;


class HeaderWidget extends Widget {
    public function init() {
    }

    public function run() {
    	$count_notification = (new Query)->from('notification')->where(['owner'=>\Yii::$app->user->id,'status'=>0])->andWhere(['not in','type',['admin']])->count();
        return $this->render('header',['count_notification'=>$count_notification]);
    }

}
