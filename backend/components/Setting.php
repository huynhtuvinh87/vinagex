<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components;

use Yii;
use yii\base\Component;
use common\models\SettingMeta;

class Setting extends Component
{

    public function get($key)
    {
        $model = SettingMeta::find()->where(['meta_key' => $key])->one();
        return $model->meta_value;
    }

}
