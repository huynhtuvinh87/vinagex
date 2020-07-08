<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\widgets;

use yii\base\Widget;
use common\models\Page;

class SidebarPageWidget extends Widget {

    public function init() {
        
    }

    public function run() {
        $model = Page::find()->where(['status' => Page::STATUS_PUBLIC])->andWhere(['not in', 'widget', [Page::WIDGET_ADDRESS, Page::WIDGET_TUTORIAL]])->all();
        $page = new Page();
        return $this->render('sidebarPage', ['model' => $model, 'page' => $page]);
    }

}
