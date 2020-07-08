<?php

namespace frontend\controllers;

use Yii;
use frontend\controllers\FrontendController;

class WishlistController extends FrontendController {

    public function init() {
        parent::init();
    }

    public function actionProduct() {
        if ($post = Yii::$app->request->post()) {
            return Yii::$app->mongodb->getCollection('wishlist')->insert([
                        "type" => "product",
                        "user_id" => \Yii::$app->user->id,
                        "product_id" => $post['product_id'],
                        "created_at" => time(),
                        "updated_at" => time()
            ]);
        }
    }

    public function actionSeller() {
        if ($post = Yii::$app->request->post()) {
            return Yii::$app->mongodb->getCollection('wishlist')->insert([
                        "type" => "seller",
                        "user_id" => \Yii::$app->user->id,
                        "seller_id" => $post['seller_id'],
                        "created_at" => time(),
                        "updated_at" => time()
            ]);
        }
    }

    public function actionRemove() {
        if ($post = Yii::$app->request->post()) {
            if (!empty($post['product_id'])) {
                return Yii::$app->mongodb->getCollection('wishlist')->remove(['user_id' => \Yii::$app->user->id, 'product_id' => $post['product_id']]);
            } else {
                return Yii::$app->mongodb->getCollection('wishlist')->remove(['user_id' => \Yii::$app->user->id, 'seller_id' => $post['seller_id']]);
            }
        }
    }

}
