<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

use yii\base\Component;

class SettingComponent extends Component {

    public function get($key) {
        $model = (new \yii\mongodb\Query())->from('setting')->where(['key' => 'config'])->one();
        return nl2br($model[$key]);
    }

    public function image($file, $size) {
        return \Yii::$app->setting->get('siteurl_cdn').'/image.php?src='.$file.'&size='.$size;
    }

}
