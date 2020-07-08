<?php

namespace frontend\controllers;

use Yii;
use common\models\Order;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use common\models\Invoice;
use common\components\Constant;
use frontend\controllers\FrontendController;

class InvoiceController extends FrontendController {

    /**
     * @inheritdoc
     */
    public function init(){
        parent::init();
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['history', 'view'],
                'rules' => [
                    [
                        'actions' => ['history', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    return Yii::$app->response->redirect(['/']);
                },
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

    public function beforeAction($action) {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionHistory() {
        $this->layout = "profile";
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find()->where(['actor' => \Yii::$app->user->id])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->view->title = Yii::t('frontend', 'Quản lý đơn hàng');
        return $this->render('history', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id) {
        $this->layout = "profile";
        $invoice = Invoice::findOne($id);
        $order = Order::find()->where(['invoice' => $id])->all();
        return $this->render('view', ['invoice' => $invoice, 'order' => $order]);
    }

    public function actionDelete($id) {
        $this->layout = "profile";

        $order = Order::find()->where(['_id' => $id, 'buyer.id' => Yii::$app->user->id])->one();
        if ($order == null) {
            return $this->redirect(['history']);
        }

        Yii::$app->mongodb->getCollection('order')->update(['_id' => $id], ['$set' => [
                'status' => Constant::STATUS_ORDER_BLOCK,
                'content' => ['Người mua tự hủy.'],
        ]]);
        //notification
        Yii::$app->mongodb->getCollection('notification')->insert([
            'type' => 'seller',
            'owner' => $order['owner']['id'],
            'content' => '<b>' . $order['buyer']['name'] . '</b> đã hủy đơn hàng #<b>' . $order['code'] . '</b>',
            'url' => '/order/filter?keywords=' . (int) $order['code'],
            'status' => 0,
            'created_at' => time()
        ]);
        //sendmail
        Yii::$app->mongodb->getCollection('mail')->insert([
            'title' => 'Đơn hàng #' . $order['code'] . ' đã được hủy theo yêu cầu của bạn',
            'type' => 'buyer_cancel',
            'code' => $order['code'],
            'layout' => 'buyer_cancel',
            'created_at' => time()
        ]);

        return $this->redirect(['view', 'id' => $order['invoice']]);
    }

}
