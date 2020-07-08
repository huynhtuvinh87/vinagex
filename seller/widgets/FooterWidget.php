<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace seller\widgets;

use yii\base\Widget;
use common\components\Constant;


class FooterWidget extends Widget {
    public function init() {
    }

    public function run() {
        return $this->render('footer');
    }

}
