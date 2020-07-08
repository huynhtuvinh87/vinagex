<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\actions;

use Yii;
use yii\widgets\ActiveForm;
use yii\base\Action;

class CreateAction extends Action
{

    public $model;

    public function run()
    {
        $model = $this->model;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        elseif ($model->load(Yii::$app->request->post()) && $model->creating())
        {
            return $this->controller->redirect(['index']);
        }
        return $this->controller->render('create', ['model' => $model]);
    }

}
