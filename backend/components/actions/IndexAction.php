<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\actions;

use yii\base\Action;

class IndexAction extends Action
{

    public $model;

    public function run()
    {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $this->model,
        ]);
        return $this->controller->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

}
