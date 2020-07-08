<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\widgets;

use Yii;
use yii\base\Widget;
use yii\mongodb\Query;

class SidebarWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        if (!Yii::$app->user->isGuest) {
            $count_notify = (new Query)->from("notification")->where(['status' => 0, 'type' => 'admin'])->count();
            return $this->render('sidebar', ['count_notify' => $count_notify]);
        }
    }

}
