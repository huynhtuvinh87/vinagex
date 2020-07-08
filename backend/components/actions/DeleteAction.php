<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\actions;

use Yii;
use yii\base\Action;

class DeleteAction extends Action
{

    public function run($id)
    {
        $this->controller->findModel($id)->delete();
        Yii::$app->session->setFlash('danger', Yii::t('app', 'You have successfully removed.'));
        return $this->controller->redirect(['index']);
    }

}
