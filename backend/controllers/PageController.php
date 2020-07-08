<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use backend\models\PageForm;
use common\models\Page;
use common\models\searchs\PageSearch;
use yii\web\NotFoundHttpException;
use backend\components\BackendController;
use yii\data\ActiveDataProvider;

class PageController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionFilter() {
        $search = new PageSearch();
        $model = new Page();
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionIndex() {
        $search = new PageSearch();
        $model = new Page();
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PageForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Thêm thành công');
            return $this->redirect(['index']);
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = new PageForm(['id'=>$id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Cập nhật thành công');
            return $this->redirect(['index']);
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionDoaction() {
        if (!empty($_POST['selection']) && !empty($_POST['action'])) {
            foreach ($_POST['selection'] as $value) {
                $this->findModel($value)->delete();
            }
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Delete success'));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app', 'Delete error'));
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
     

        $collection = Yii::$app->mongodb->getCollection('page');

        $model = $collection->findOne(['_id'=>$id]);
        if(!empty($model['image'])){
            unlink(\Yii::getAlias("@cdn/web/".$model['image']));
        }

        $collection->remove(['_id'=>$id]);
       
       
        Yii::$app->session->setFlash('success', 'Xóa thành công');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PageForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
