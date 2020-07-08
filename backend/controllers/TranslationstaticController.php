<?php

namespace backend\controllers;

use Yii;
use backend\components\BackendController;
use yii\data\ArrayDataProvider;
use backend\models\TranslationStaticForm;
use yii\mongodb\Query;

class TranslationstaticController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    public function filter(){
        
    }

    public function actionEn(){
        $model = new TranslationStaticForm();
        $translation = (new Query)->from('translation_static')->where(['language'=>'en'])->one();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $translation['messages'],
            'pagination' => [
                'pageSize' => 10,
        ]]);
//        if($model->load(Yii::$app->request->post()) && $model->save()){
//            \Yii::$app->getSession()->setFlash('success', 'Thêm thành công');
//            return $this->redirect(['en']);
//        }
        return $this->render('en',['model'=>$model,'dataProvider'=>$dataProvider]);
    }

    public function actionVi(){
        $model = new TranslationStaticForm();
        $translation = (new Query)->from('translation_static')->where(['language'=>'vi'])->one();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $translation['messages'],
            'pagination' => [
                'pageSize' => 10,
        ]]);
        if($model->load(Yii::$app->request->post()) && $model->save()){
            \Yii::$app->getSession()->setFlash('success', 'Thêm thành công');
            return $this->redirect(Yii::$app->request->referrer ?: ['vi']);
        }
        return $this->render('vi',['model'=>$model,'dataProvider'=>$dataProvider]);
    }

    public function actionUpdate($id){
        $model = new TranslationStaticForm(['id'=>$id,'language'=>$_GET['language']]);
        $translation = (new Query)->from('translation_static')->where(['language'=>$_GET['language']])->one();
        $translation_vi = (new Query)->from('translation_static')->where(['language'=>'vi'])->one();
        $key = array_search($model->_messages['message'], array_column($translation_vi['messages'], 'message'));
        $vi = !empty($key)?$translation_vi['messages'][$key]:'';
        $dataProvider = new ArrayDataProvider([
            'allModels' => $translation['messages'],
            'pagination' => [
                'pageSize' => 10,
        ]]);
        if($model->load(Yii::$app->request->post()) && $model->save()){
            \Yii::$app->getSession()->setFlash('success', 'Sửa thành công');
            return $this->redirect(Yii::$app->request->referrer ?: [$_GET['language']]);
        }
        return $this->render($_GET['language'],['model'=>$model,'dataProvider'=>$dataProvider,'vi'=>$vi]);
    }

//    public function actionDelete($id){
//        $translation = (new Query)->from('translation_static')->where(['language'=>$_GET['language']])->one();
//        $message = $translation['messages'][$id];
//        Yii::$app->mongodb->getCollection('translation_static')->update(['language'=>$_GET['language']],['$pull'=>[
//                    'messages' => $message
//                ]]);
//        \Yii::$app->getSession()->setFlash('success', 'Xóa thành công');
//        return $this->redirect(Yii::$app->request->referrer ?: [$_GET['language']]);
//    }

    public function actionCn(){
        return $this->render('cn');
    }
}
