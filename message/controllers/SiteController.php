<?php

namespace message\controllers;

use Yii;
use yii\web\Controller;
use yii\mongodb\Query;
use common\models\Product;
use common\models\Message;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\components\Constant;
use yii\helpers\Json;

/**
 * Site controller
 */
class SiteController extends Controller {

    public function init() {
        parent::init();
    }

    /**
     * List of allowed domains.
     * Note: Restriction works only for AJAX (using CORS, is not secure).
     *
     * @return array List of domains, that can access to this API
     */
    public static function allowedDomains() {
        return [
            // '*',                        // star allows all domains
            'http://message.vinagex.loc',
            'http://message.vinagex.com',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return array_merge(parent::behaviors(), [
            // For cross-domain AJAX request
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to domains:
                    'Origin' => static::allowedDomains(),
                    'Access-Control-Request-Method' => ['POST' . 'GET'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 8090, // Cache (seconds)
                ],
            ],
        ]);
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

    public function actionUrl() {
        $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_message')));
    }

    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_message')));
        }
        $message = (new Query())->from('message')->where(['receive.id' => \Yii::$app->user->id])->orWhere(['sender.id' => \Yii::$app->user->id])->limit(1)->orderBy(['last_msg_time' => SORT_DESC])->all();
        if ($message) {
            return $this->redirect(['chat', 'id' => (string) $message[0]['_id']]);
        } else {
            return $this->render('index');
        }
    }

    public function actionMessage($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_message') . '/message/' . $id));
        }

        $actor = (new Query())->from('message')->where(['actor.id' => \Yii::$app->user->id])->orderBy(['last_msg_time' => SORT_DESC])->all();
        $message = Message::findOne($id);
        $product = Product::findOne($message->product['id']);
        $conversation = (new Query())->from('conversation')
                ->where(['owner' => \Yii::$app->user->id, 'actor' => $message->owner['id'], 'product_id' => $product->id])
                ->orWhere(['actor' => \Yii::$app->user->id, 'owner' => $message->owner['id'], 'product_id' => $product->id])
                ->all();
        return $this->render('message', ['actor' => $actor, 'product' => $product, 'conversation' => $conversation, 'message' => $message]);
    }

    public function actionTest() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_message')));
        }
        $message = (new Query())->from('message')->where(['sender.id' => \Yii::$app->user->id])->orWhere(['receive.id' => \Yii::$app->user->id])->limit(1)->orderBy(['last_msg_time' => SORT_DESC])->all();
        if ($message) {
            return $this->redirect(['chat', 'id' => $message[0]['_id']]);
        } else {
            return $this->render('test');
        }
    }

    public function actionChat($id) {
        $this->layout = "chat";
        $actor = (new Query())->from('message')->where(['sender.id' => \Yii::$app->user->id])->orWhere(['receive.id' => \Yii::$app->user->id])->orderBy(['last_msg_time' => SORT_DESC])->all();
        $message = Message::findOne($id);
        $product = Product::findOne($message->product['id']);
        $conversation = (new Query())->from('conversation')->where(['message_id' => $id])->all();
        if (Yii::$app->user->id != $message->sender_last_msg && $message->status == Constant::STATUS_NOACTIVE) {
            Yii::$app->mongodb->getCollection('message')->update(['_id' => $id], ['$set' => ['status' => Constant::STATUS_ACTIVE]]);
        }
        if (\Yii::$app->user->id == $message->sender['id']) {
            $receive = $message->receive;
        } else {
            $receive = $message->sender;
        }
        if (Yii::$app->request->post()) {
            $data = [
                'message_id' => $id,
                'product_id' => $product->id,
                'sender' => [
                    'id' => \Yii::$app->user->id,
                    'fullname' => Yii::$app->user->identity->fullname,
                    'fullname' => Yii::$app->user->identity->username
                ],
                'receive' => $receive,
                'date' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d h:i:s"),
                'avatar' => $product->images[0],
                'message' => Yii::$app->request->post('message')
            ];

            Yii::$app->mongodb->getCollection('conversation')->insert($data);

            Yii::$app->mongodb->getCollection('message')->update(['_id' => $id], ['$set' => ['status' => Constant::STATUS_NOACTIVE, 'sender_last_msg' => \Yii::$app->user->id, 'last_msg' => $data['message'], 'last_msg_time' => \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d H:i:s")]]);

            Yii::$app->redis->executeCommand('PUBLISH', [
                'channel' => 'chat',
                'messages' => Json::encode(['message' => Yii::$app->request->post('message'), 'sender' => Yii::$app->user->id, 'receive' => $receive['id'], 'message_id' => $message->id])
            ]);
            return true;
        }
        return $this->render('chat', ['actor' => $actor, 'product' => $product, 'conversation' => $conversation, 'message' => $message]);
    }

    public function actionFocus() {
        if (Yii::$app->request->post()) {
            Yii::$app->redis->executeCommand('PUBLISH', [
                'channel' => 'focus',
                'messages' => Json::encode(['message' => Yii::$app->request->post('focus'), 'sender' => Yii::$app->user->id, 'message_id' => Yii::$app->request->post('message')])
            ]);
        }
        return true;
    }

    public function actionRead() {
        if (Yii::$app->request->post()) {
          return Yii::$app->mongodb->getCollection('message')->update(['_id' => Yii::$app->request->post('id')], ['$set' => ['status' => Constant::STATUS_ACTIVE]]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

//    public function actionTest() {
//        $this->layout = 'test';
//        return $this->render('test');
//    }
}
