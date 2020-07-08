<?php

namespace frontend\controllers;

use Yii;
use frontend\models\CommentForm;
use common\models\Product;
use common\models\Comment;

class CommentController extends \yii\web\Controller {

    public function actionCreate() {
        $model = new CommentForm();
        $model->ip = Yii::$app->getRequest()->getUserIP();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->content && $model->name) {
                if (!empty($model->parent)) {
                    $product = Product::findOne($model->product_id);
                    $data = [
                        'id' => (string) new \MongoDB\BSON\ObjectID(),
                        'ip' => $model->ip,
                        'sex' => $model->sex,
                        'actor_id' => \Yii::$app->user->id,
                        'name' => $model->name,
                        'email' => $model->email,
                        'content' => $model->content,
                        'status' => Yii::$app->user->id == $product->owner['id'] ? Comment::STATUS_ACTIVE : Comment::STATUS_NOACTIVE,
                        'created_at' => time(),
                        'updated_at' => time()
                    ];
                    Yii::$app->mongodb->getCollection('comment')->update(['_id' => $model->parent], ['$push' => ['answers' => $data]]);
                    Yii::$app->mongodb->getCollection('comment')->update(['_id' => $model->parent], ['$set' => [
                            'count_answer' => (int) Comment::findOne($model->parent)->count_answer + 1,
                    ]]);

                    if ($data['status'] == Comment::STATUS_NOACTIVE) {
                        Yii::$app->mongodb->getCollection('notification')->insert([
                            'type' => 'seller',
                            'owner' => $product->owner['id'],
                            'content' => '<b>' . $model->name . '</b> cũng đã bình luận sản phẩm <b>' . $product->title . '</b>',
                            'url' => Yii::$app->setting->get('siteurl_seller') . '/comment/index?CommentSearch[id]=' . (string) $model->parent,
                            'status' => 0,
                            'created_at' => time()
                        ]);

                        Yii::$app->mongodb->getCollection('notification')->insert([
                            'type' => 'admin',
                            'content' => '<b>' . $model->name . '</b> cũng đã bình luận sản phẩm <b>' . $product->title . '</b>',
                            'url' => '/comment/index?CommentSearch[id]=' . (string) $model->parent,
                            'status' => 0,
                            'created_at' => time()
                        ]);
                    }
                } else {
                    $model->save();
                }
            } else {
                echo 'error';
                exit;
            }
        }
    }

    public function actionAnswer($id) {
        $model = Comment::findOne($id);
        return $this->renderAjax('answer', ['model' => $model]);
    }

}
