<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\Review;
use common\models\searchs\ReviewSearch;
use yii\web\NotFoundHttpException;
use backend\components\BackendController;
use yii\data\ArrayDataProvider;

class ReviewController extends BackendController {

    public function behaviors() {
        return parent::behaviors();
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $search = new ReviewSearch();
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

    public function actionStatus() {
        if (!empty(Yii::$app->request->post('selection')) && $post = Yii::$app->request->post()) {
            foreach ($post['selection'] as $value) {
                $review = Review::findOne($value);
                Yii::$app->mongodb->getCollection('review')->update(['_id' => $value], ['status' => Review::STATUS_ACTIVE]);
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'seller',
                    'owner' => $review['owner']['id'],
                    'content' => '<b>' . $review->actor['fullname'] . '</b> đã đánh gía sản phẩm <b>' . $review->product['title'] . '</b> ' . $review->star . ' sao.',
                    'url' => \Yii::$app->setting->get('siteurl') . '/' . $review->product['slug'] . '-' . $review->product['id'] . '#section-review',
                    'status' => 0,
                    'created_at' => time()
                ]);
            }
        }
        return $this->redirect(['index']);
    }

    public function actionDoaction() {
        if ($post = Yii::$app->request->post()) {
            $review = Review::findOne($post['id']);
            if ($review) {
                if ($post['status'] == Review::STATUS_ACTIVE) {
                    Yii::$app->mongodb->getCollection('notification')->insert([
                        'type' => 'seller',
                        'owner' => $review['owner']['id'],
                        'content' => '<b>' . $review->actor['fullname'] . '</b> đã đánh gía sản phẩm <b>' . $review->product['title'] . '</b> ' . $review->star . ' sao.',
                        'url' => \Yii::$app->setting->get('siteurl') . '/' . $review->product['slug'] . '-' . $review->product['id'] . '#section-review',
                        'status' => 0,
                        'created_at' => time()
                    ]);
                } elseif ($post['status'] == Review::STATUS_NOACTIVE) {
                    Yii::$app->mongodb->getCollection('notification')->insert([
                        'type' => 'seller',
                        'owner' => $review['owner']['id'],
                        'content' => '<b>' . $review->actor['fullname'] . '</b> đã đánh gía sản phẩm <b>' . $review->product['title'] . '</b> ' . $review->star . ' sao. (đánh gía không được duyệt)',
                        'url' => \Yii::$app->setting->get('siteurl') . '/' . $review->product['slug'] . '-' . $review->product['id'] . '#section-review',
                        'status' => 0,
                        'created_at' => time()
                    ]);
                }
                return Yii::$app->mongodb->getCollection('review')->update(['_id' => $post['id']], ['status' => (int) $post['status']]);
            }
        }
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
        if (($model = Review::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
    }

}
