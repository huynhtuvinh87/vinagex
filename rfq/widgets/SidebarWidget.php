<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace rfq\widgets;

use yii\base\Widget;
use yii\mongodb\Query;
use common\components\Constant;

class SidebarWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $count_rfq = (new Query)->from('rfq')->where(['owner.id' => \Yii::$app->user->id])->count();
        $count_apply = (new Query)->from('rfq_offer')->where(['actor.id' => \Yii::$app->user->id])->count();
        if (!\Yii::$app->user->isGuest) {
            return $this->render('sidebar', [
                        'count_rfq' => $count_rfq,
                        'count_apply' => $count_apply
            ]);
        }
    }

}
