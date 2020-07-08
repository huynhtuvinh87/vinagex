<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\widgets;

use yii\base\Widget;
use common\models\Relationship;
use common\models\Tag;

class TagWidget extends Widget {

    public $model;
    public $form;

    public function run() {
        $data = [];
        $tabs = Tag::find()->all();

        if (!empty($tabs)) {
            foreach ($tabs as $key => $value) {
                $data[$value->id] = $value->title;
            }
        }
        return $this->render('tag', ['form' => $this->form, 'model' => $this->model, 'tag' => $data]);
    }

}
