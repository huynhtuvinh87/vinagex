<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets;

use yii\base\Widget;
use frontend\models\ProductFilter;

class FilterWidget extends Widget {

    public $layout;

    public function init() {
        
    }

    public function run() {
        $model = new ProductFilter;
        return $this->render('filter', ['model' => $model, 'layout']);
    }

}
