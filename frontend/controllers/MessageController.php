<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Product;
use yii\web\NotFoundHttpException;
use yii\mongodb\Query;
use common\components\Constant;

class MessageController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionView($id) {
        $product = Product::findOne($id);
        if (!$product) {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
        if (\Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->urlManager->createAbsoluteUrl(['/message/view/' . $product->id])));
        } elseif (!\Yii::$app->user->isGuest && ($product->owner['id'] == \Yii::$app->user->id)) {
            return $this->redirect(Yii::$app->setting->get('siteurl_message'));
        }
        $this->customer($id);
       
//        $this->seller($id);
        $this->redirect(Yii::$app->setting->get('siteurl_message'));
    }

    public function customer($id) {
        $collection = Yii::$app->mongodb->getCollection('message');
        $product = Product::findOne($id);
        $msg = (new Query())->select(['owner', 'actor', 'product'])->from('message')->where(['sender.id' => Yii::$app->user->id, 'receive.id' => $product->owner['id'], 'product.id' => $id])->one();
        if (!$msg) {
            $data = [
                'product' => [
                    'id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price' => $product->price
                ],
                'sender' => [
                    'id' => \Yii::$app->user->id,
                    'fullname' => \Yii::$app->user->identity->fullname,
                    'username' => \Yii::$app->user->identity->username
                ],
                'receive' => $product->owner,
                'avatar' => $product->images[0],
                'last_msg' => 'Xin chào nhà vườn ' . $product->owner['garden_name'],
                'last_msg_time' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s"),
                'order' => 1,
                'created_at' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s"),
                'status' => Constant::STATUS_NOACTIVE
            ];
            $message_id = $collection->insert($data);
            $this->message((string) $message_id, $data['sender'], $data['receive'], 'Xin chào nhà vườn ' . $product->owner['garden_name'], $product->id);
        }
    }

    public function seller($id) {
        $collection = Yii::$app->mongodb->getCollection('message');
        $product = Product::findOne($id);
        $msg = (new Query())->select(['owner', 'actor', 'product_id'])->from('message')->where(['actor.id' => Yii::$app->user->id, 'owner.id' => $product->owner['id'], 'product.id' => $id])->one();
        if (!$msg) {
            $data = [
                'product' => [
                    'id' => $product->id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'price' => $product->price
                ],
                'owner' => $product->owner,
                'actor' => [
                    'id' => \Yii::$app->user->id,
                    'fullname' => \Yii::$app->user->identity->fullname,
                    'username' => \Yii::$app->user->identity->username
                ],
                'avatar' => $product->images[0],
                'last_msg' => Yii::t('common', 'Xin chào nhà vườn') . ' ' . $product->owner['garden_name'],
                'last_msg_time' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s"),
                'order' => 2,
                'created_at' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s"),
                'status' => 'login'
            ];
            $collection->insert($data);
        }
    }

    public function message($message_id, $sender, $receive, $msg, $product_id) {
        $product = Product::findOne($product_id);
        $data = [
            'message_id' => $message_id,
            'product_id' => $product_id,
            'sender' => $sender,
            'receive' => $receive,
            'avatar' => $product->images[0],
            'message' => $msg,
            'date' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s")
        ];
        $collection = Yii::$app->mongodb->getCollection('conversation')->insert($data);
    }

}
