<?php

namespace backend\controllers;

use Yii;
use backend\components\BackendController;
use yii\data\ArrayDataProvider;
use backend\models\TranslationProductForm;
use yii\mongodb\Query;

class TranslationproductController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    public function actionEn() {
        $model = new TranslationProductForm();
        $translation = (new Query)->from('translation_product')->where(['language' => 'en'])->one();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $translation['messages'],
            'pagination' => [
                'pageSize' => 10,
        ]]);
        return $this->render('en', ['model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionUpdate($id) {
        $model = new TranslationProductForm(['id' => $id, 'language' => $_GET['language']]);
        $translation = (new Query)->from('translation_product')->where(['language' => $_GET['language']])->one();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $translation['messages'],
            'pagination' => [
                'pageSize' => 10,
        ]]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', 'Sửa thành công');
            return $this->redirect(Yii::$app->request->referrer ?: [$_GET['language']]);
        }
        return $this->render($_GET['language'], ['model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionCn() {
        return $this->render('cn');
    }

}
