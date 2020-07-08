<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\Setting;
use common\models\Wishlist;
use yii\data\ActiveDataProvider;
use frontend\controllers\FrontendController;

/**
 * Site controller
 */
class CustomerController extends FrontendController {

    public $_setting;

    public function init() {
        parent::init();
        $this->_setting = Setting::findOne(['key' => 'config']);
        $this->layout = 'profile';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['wishlist', 'quotation'],
                'rules' => [
                    [
                        'actions' => ['wishlist', 'wishlistseller'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionWishlist() {
        $dataProvider = new ActiveDataProvider([
            'query' => Wishlist::find()->where(['user_id' => Yii::$app->user->id, 'type' => 'product']),
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = \Yii::t('common', 'Sản phẩm yêu thích');
        return $this->render('wishlist', [
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionWishlistseller() {
        $dataProvider = new ActiveDataProvider([
            'query' => Wishlist::find()->where(['user_id' => Yii::$app->user->id, 'type' => 'seller']),
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = \Yii::t('common', 'Nhà vườn đã quan tâm');
        return $this->render('seller', [
                    'dataProvider' => $dataProvider
        ]);
    }

}
