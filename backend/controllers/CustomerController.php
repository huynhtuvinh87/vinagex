<?php

namespace backend\controllers;

use Yii;
use common\models\searchs\QuotationSearch;
use common\models\Quotations;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use backend\components\BackendController;
use common\models\User;
use common\models\UserInfo;

class CustomerController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $query = User::find()->where(['role' => User::ROLE_MEMBER]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->view->title = 'Danh sách khách hàng';
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = User::findOne($id);
        $data = [];
        $data['active'] = $model->active;
        if ($model->load(Yii::$app->request->post())) {
            $data['active']['address'] = $model->active['address'];
            $data['active']['phone'] = $model->active['phone'];
            Yii::$app->mongodb->getCollection('user')->update(['_id' => $id], ['$set' => $data]);
            return $this->redirect(['view','id'=>$id]);
        }

        $this->view->title = $model->fullname;
        return $this->render('view', ['model' => $model]);
    }

    public function actionDelete($id){
        $model = User::findOne($id);
        if(!$model){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        Yii::$app->mongodb->getCollection('user')->remove(['_id' => $id]);
        \Yii::$app->session->setFlash('success', 'Xoá thành công');
        return $this->redirect(['index']);
    }

    public function actionRemoveimg(){
        if($post = Yii::$app->request->post()){
            $model = User::findOne($post['id']);
            $img = $model->image_verification[$post['key']];
            $filepath = \Yii::getAlias("@cdn/web/" . $img);
            unlink($filepath);
            
            Yii::$app->mongodb->getCollection('user')->update(['_id'=>$model->id],['$pull'=>[
                'image_verification' => $img
            ]]);
            \Yii::$app->session->setFlash('success', 'Bạn đã xóa hình ảnh thành công');
            return $this->redirect(['view','id'=>$model->id]);
        }
    }

    public function actionQuotation() {

        $search = new QuotationSearch();
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionDoaction() {
        if (!empty($_POST['action']) && ($_POST['action'] == "change")) {
            foreach ($_POST['status'] as $k => $value) {
                $model = $this->findModel($k);
                $model->status = (int) $_POST['status'][$k];
                $model->save();
            }
            \Yii::$app->session->setFlash('success', 'Bạn đã cập nhật thành công');
            return $this->redirect(['index']);
        }
        if (!empty($_POST['action']) && ($_POST['action'] == "delete")) {
            foreach ($_POST['selection'] as $k => $value) {
                $model = $this->findModel($value)->delete();
            }
            \Yii::$app->session->setFlash('success', 'Bạn đã xoá thành công');
            return $this->redirect(['index']);
        }
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
        if (($model = Quotations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
