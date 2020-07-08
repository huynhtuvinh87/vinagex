<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace rfq\widgets;

use Yii;
use yii\base\Widget;
use common\models\Category;

class HeaderWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $category = Category::find()->orderBy(['order' => SORT_ASC])->all();
        return $this->render('header', [
                    'category' => $category,
        ]);
    }

}
