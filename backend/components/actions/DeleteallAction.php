<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\components\actions;

use yii\base\Action;

class DeleteallAction extends Action
{

    public function run()
    {
        if (!empty($_POST['ids']))
        {
            foreach ($_POST['ids'] as $value)
            {
                $model = $this->controller->findModel($value)->delete();
            }
        }
        \Yii::$app->session->setFlash('danger', \Yii::t('app', 'You have successfully removed.'));
        return $this->controller->redirect(['index']);
    }

}
