<?php

namespace backend\controllers;

use Yii;
use common\models\Comment;
use common\models\searchs\CommentSearch;
use yii\web\NotFoundHttpException;
use backend\components\BackendController;
use yii\data\ArrayDataProvider;

class CommentController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $search = new CommentSearch();
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $dataProvider = new ArrayDataProvider([
            'key' => 'id',
            'allModels' => $model->products,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
                    'model' => $model,
                    'products' => $dataProvider
        ]);
    }

    public function actionDoaction() {
        if (!empty($_POST['action']) && ($_POST['action'] == "change")) {
            foreach ($_POST['status'] as $k => $value) {
                $model = $this->findModel($k);
                $model->status = (int) $_POST['status'][$k];
                $model->content = $_POST['content'][$k];
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

    public function actionStatus($id) {
        $model = $this->findModel($id);
        $model->status = (int) $_GET['s'];
        

        if ($model->save()) {
              $data =[];
            if($model->status == Comment::STATUS_ACTIVE){
                $data = [
                    'type' => 'buyer',
                    'owner' => $model->id_owner,
                    'content' => 'Bình luận của bạn ở sản phẩm <b>'.$model->product['title'].'</b> đã được duyệt.',
                    'url' => Yii::$app->setting->get('siteurl').'/'.$model->product['slug'].'-'.$model->product['id'].'#list-comment',
                    'status' => 0,
                    'created_at' => time()
                ];
            }elseif($model->status == Comment::STATUS_SPAM){
                $data = [
                    'type' => 'buyer',
                    'owner' => $model->id_owner,
                    'content' => 'Bình luận của bạn ở sản phẩm <b>'.$model->product['title'].'</b> bị cho là spam.',
                    'url' => Yii::$app->setting->get('siteurl').'/'.$model->product['slug'].'-'.$model->product['id'].'#list-comment',
                    'status' => 0,
                    'created_at' => time()
                ];
            }elseif($model->status == Comment::STATUS_TRASH){
                $data = [
                    'type' => 'buyer',
                    'owner' => $model->id_owner,
                    'content' => 'Bình luận của bạn ở sản phẩm <b>'.$model->product['title'].'</b> đã bị xóa.',
                    'url' => Yii::$app->setting->get('siteurl').'/'.$model->product['slug'].'-'.$model->product['id'].'#list-comment',
                    'status' => 0,
                    'created_at' => time()
                ];
            } 
            Yii::$app->mongodb->getCollection('notification')->insert($data);
            \Yii::$app->session->setFlash('success', 'Bạn đã xử lý thành công');
            return $this->redirect(['index']);
        }
    }

    public function actionAnswer($id) {
        $model = Comment::findOne($id);
        return $this->renderAjax('answer', ['model' => $model]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

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
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
