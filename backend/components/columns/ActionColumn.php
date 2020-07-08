<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\columns;

use Yii;
use Closure;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{

    protected function initDefaultButtons()
    {
        $controller            = Yii::$app->controller->id;
        $this->buttons['view'] = function ($url, $model, $key)
        {
            $options = array_merge([
                'title'      => Yii::t('yii', 'Xem'),
                'aria-label' => Yii::t('yii', 'Xem'),
                'data-pjax'  => '0',
                    ], $this->buttonOptions);
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
        };
        $this->buttons['update'] = function ($url, $model, $key)
        {
            $options = array_merge([
                'title'      => Yii::t('yii', 'Cập nhật'),
                'aria-label' => Yii::t('yii', 'Cập nhật'),
                'data-pjax'  => '0',
                    ], $this->buttonOptions);
            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
        };
        $this->buttons['delete'] = function ($url, $model, $key)
        {
            $options = array_merge([
                'title'        => Yii::t('yii', 'Xóa'),
                'aria-label'   => Yii::t('yii', 'Xóa'),
                'data-confirm' => Yii::t('yii', 'Bạn có muốn chắc xóa mẫu tin này không?'),
                'data-method'  => 'post',
                'data-pjax'    => '0',
                    ], $this->buttonOptions);
            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
        };
    }

}
