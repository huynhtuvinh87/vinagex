<?php

namespace backend\controllers;

use Yii;
use common\models\Setting;
use backend\components\BackendController;

class SettingController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex() {
        $model = Setting::findOne(['key' => 'config']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('index', [
                    'model' => $model
        ]);
    }

}
