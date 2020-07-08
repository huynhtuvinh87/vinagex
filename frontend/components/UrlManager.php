<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\components;

use yii\web\UrlManager;
use Yii;

class UrlManager extends UrlManager {

    public function createUrl($params) {
        if (!isset($params['language'])) {
            if (Yii::$app->session->has('language'))
                Yii::$app->language = Yii::$app->session->get('language');
            else if (isset(Yii::$app->request->cookies['language']))
                Yii::$app->language = Yii::$app->request->cookies['language']->value;
            $params['language'] = Yii::$app->language;
        }
        return parent::createUrl($params);
    }

}
