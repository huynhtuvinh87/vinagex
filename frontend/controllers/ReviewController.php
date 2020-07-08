<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Review;
use common\models\Product;
use yii\filters\AccessControl;
use yii\bootstrap\ActiveForm;

class ReviewController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id) {
        $product = Product::findOne($id);
        $model = Review::findOne(['actor.id' => \Yii::$app->user->id, 'product.id' => $product->id]);
        if(!$model){
            $model = new Review();
        }
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            $data['product'] = [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
            ];
            $data['actor'] = [
                'id' => \Yii::$app->user->id,
                'fullname' => \Yii::$app->user->identity->fullname,
                'username' => \Yii::$app->user->identity->username
            ];
            $data['ip'] = Yii::$app->getRequest()->getUserIP();
            $data['owner'] = $product->owner;
            $data['created_at'] = time();
            $data['status'] = 0;
            $data['updated_at'] = time();

            $data['star'] = (int) $model->star;
            $data['content'] = $model->content;

            if(empty($model->id)){
                $review = Yii::$app->mongodb->getCollection('review')->insert(array_merge(['created_at' => time()],$data));
            }else{
                Yii::$app->mongodb->getCollection('review')->update(['_id'=>$model->id],$data);
                $review = $model->id;
            }
            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'admin',
                'content' => '<b>' . \Yii::$app->user->identity->fullname . '</b> đã đánh gía sản phẩm của <b>' . $product->owner['garden_name'] . '</b>',
                'url' => '/review/index?ReviewSearch%5Bkeywords%5D=' . $review,
                'status' => 0,
                'created_at' => time()
            ]);
            \Yii::$app->getSession()->setFlash('success', \Yii::t('common', 'Cảm ơn bạn đã gửi đánh giá cho sản phẩm này!'));
            return $this->redirect('/' . $product->slug . '-' . $product->id);

        }
        return $this->renderAjax('_form', ['model' => $model, 'product' => $product]);
    }

}


