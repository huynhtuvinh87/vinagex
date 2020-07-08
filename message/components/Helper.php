<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace message\components;

use Yii;
use yii\base\Component;

class Helper extends Component {

    public function init() {
        parent::init();
    }

    public function childadded() {
        $model = (new \yii\mongodb\Query())->from('message')->where(['owner.id' => Yii::$app->user->id, 'status' => 'login'])->one();
        return $model;
    }

}
