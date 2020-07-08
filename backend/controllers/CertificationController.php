<?php 

namespace backend\controllers;

use Yii;
use backend\models\CertificationForm;
use backend\components\BackendController;
use common\components\Constant;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use yii\widgets\ActiveForm;

class CertificationController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    public function actionIndex(){

    	$dataProvider = new ActiveDataProvider([
            'query' => (new Query)->from('certification')->orderBy(['_id' => SORT_DESC]),
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //     return $this->redirect(['index']);
        // }

    	return $this->render('index',[
    		'dataProvider' => $dataProvider,
    	]);
    }

    public function actionCreate(){

    	$model = new CertificationForm();

    	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post()) && $model->save()){
	    		\Yii::$app->getSession()->setFlash('success', 'Thêm mới thành công');
	    		return $this->redirect(['certification/index']);
	    }

        return $this->renderAjax('create',[
		    		'model' => $model,
		    	]);
    }

    public function actionUpdate($id){

    	$model = new CertificationForm(['id'=>$id]);
    	
    	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post()) && $model->save()){
	    		\Yii::$app->getSession()->setFlash('success', 'Cập nhật thành công');
	    		return $this->redirect(['certification/index']);
	    }

        return $this->renderAjax('update',[
		    		'model' => $model,
		    	]);
    }

    public function actionDelete($id){
    	Yii::$app->mongodb->getCollection('certification')->remove(['_id'=>$id]);
    	\Yii::$app->getSession()->setFlash('success', 'Xóa thành công');
    	return $this->redirect(['index']);
    }

}


 ?>