<?php

namespace seller\controllers;

use Yii;
use common\models\Comment;
use common\models\searchs\CommentSearch;
use yii\web\NotFoundHttpException;

class CommentController extends ManagerController {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $search = new CommentSearch();
        $search->seller = Yii::$app->user->id;
        $dataProvider = $search->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'search' => $search
        ]);
    }

    public function actionStatus($id) {
        $model = $this->findModel($id);
        $model->status = (int) $_GET['s'];
        if ($model->save()) {
            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'buyer',
                'owner' => $model->id_owner,
                'content' => 'Bình luận sản phẩm <b>'.$model->product['title'].'</b> của bạn đã được duyệt.',
                'url' => Yii::$app->setting->get('siteurl').'/'.$model->product['slug'].'-'.$model->product['id'].'#section-comment',
                'status' => 0,
                'created_at' => time()
            ]);
            \Yii::$app->session->setFlash('success', 'Bạn đã xử lý thành công');
            return $this->redirect(['index']);
        }
    }

    public function actionAnswer($id) {
        $model = $this->findModel($id);
        return $this->renderAjax('answer', ['model' => $model]);
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
