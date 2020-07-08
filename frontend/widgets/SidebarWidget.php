<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Page;

class SidebarWidget extends Widget {

    public function init() {
    }

    public function run() {
        $model = Page::find()->where(['widget'=>Page::WIDGET_TUTORIAL,'status'=>Page::STATUS_PUBLIC])->all();
        return $this->render('sidebar',['model'=>$model]);
    }

}
