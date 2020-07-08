<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets;

use yii\base\Widget;
use frontend\models\City;

class CityWidget extends Widget {

    public function init() {
    }

    public function run() {
        $model = new City;
        return $this->render('city', ['model' => $model]);
    }

}
