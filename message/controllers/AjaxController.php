<?php

namespace message\controllers;

use Yii;
use yii\web\Controller;
use message\models\Order;
use common\models\Setting;
use common\models\Product;
use yii\mongodb\Query;
use common\models\User;

class AjaxController extends Controller {

    public $_token;
    public $_setting;

    public function init() {
        parent::init();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->_setting = Setting::findOne(['key' => 'config']);
    }

    public function beforeAction($action) {
        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionOrder() {
        $model = new Order;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'ok';
        }
    }

    public function actionUser() {
        $query = (new Query());
        $msg = $query->from('message')->where(['actor.id' => \Yii::$app->user->id])->orderBy(['last_msg_time' => SORT_DESC])->all();
        return ['data' => $msg];
    }

    public function actionSendmessage() {
        $product = Product::findOne($_POST['product_id']);
        $data = [
            'product_id' => $product->id,
            'owner' => \Yii::$app->user->id,
            'actor' => $_POST['actor'],
            'fullname' => \Yii::$app->user->identity->fullname,
            'date' => !empty($_POST['date']) ? $_POST['date'] : \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d h:i:s"),
            'avatar' => $product->images[0],
        ];
        $images = json_decode($_POST['images']);
        if (!empty($_POST['message']) && count($images) < 1) {
            $data = array_merge($data, ['message' => $_POST['message']]);
        } else if (!empty($_POST['message']) && count($images) > 0) {
            $h = 0;
            foreach ($images as $image) {
                $n = $this->arrayToBinaryString($image->binary);
                $this->createImg($n, $image->name, 'image/png');
                if ($h == 0) {
                    $data = array_merge($data, ['message' => $_POST['message'], 'image' => '/uploads/' . $image->name]);
                } else {
                    $data = array_merge($data, ['image' => '/uploads/' . $image->name]);
                }
                $h++;
            }
        } else if (empty($_POST['message']) && count($images) > 0) {
            foreach ($images as $image) {
                $n = $this->arrayToBinaryString($image->binary);
                $this->createImg($n, $image->name, 'image/png');
                $data = array_merge($data, ['image' => '/uploads/' . $image->name]);
            }
        }
        $collection = Yii::$app->mongodb->getCollection('conversation')->insert($data);
        Yii::$app->mongodb->getCollection('message')->update(['product.id' => $product->id, 'owner.id' => $data['owner']], ['$set' => [
                'last_msg' => $_POST['message'],
                'last_msg_time' => $data['date']
        ]]);
        Yii::$app->mongodb->getCollection('message')->update(['product.id' => $product->id, 'owner.id' => $data['actor']], ['$set' => [
                'last_msg' => $_POST['message'],
                'last_msg_time' => $data['date']
        ]]);
        $msg = (new \yii\mongodb\Query())
                ->from('message')
                ->where(['owner.id' => $data['owner'], 'actor.id' => $data['actor'], 'product.id' => $_POST['product_id']])
                ->one();
        $data = array_merge($data, ['msg_id' => (string) $msg['_id']]);
        $data['status'] = 'success';
        return $data;
    }

    public function actionCountmsg() {
        $msg = (new \yii\mongodb\Query())
                ->from('message')
                ->where(['owner.id' => $_POST['owner'], 'actor.id' => $_POST['actor'], 'product.id' => $_POST['product_id']])
                ->one();
        if (!empty($_POST['action']) && $_POST['action'] == 'add') {
            $count = $msg['last_msg_count'] + 1;
        } else {
            $count = 0;
        }
        Yii::$app->mongodb->getCollection('message')->update(['_id' => (string) $msg['_id']], ['$set' => [
                'last_msg_count' => $count,
                'status' => 'online',
        ]]);
        return [
            'type' => \Yii::$app->user->identity->role,
            'user_id' => $_POST['owner'],
            'last_msg_count' => $count
        ];
    }

    // upload image
    public function arrayToBinaryString($arr) {
        $str = "";
        foreach ($arr as $elm) {
            $str .= chr((int) $elm);
        }
        return $str;
    }

    function createImg($string, $name, $type) {
        $im = imagecreatefromstring($string);
        if ($type == 'image/png') {
            imageAlphaBlending($im, true);
            imageSaveAlpha($im, true);
            imagepng($im, 'uploads/' . $name);
        } else if ($type == 'image/gif') {
            imagegif($im, 'uploas/' . $name);
        } else {
            imagejpeg($im, 'uploads/' . $name);
        }
        imagedestroy($im);
    }

    public function actionMessages() {
        $data = array();
        $query = (new \yii\mongodb\Query());
        $conversation = $query->from('conversation')
                ->where(['owner' => \Yii::$app->user->id, 'actor' => $_POST['actor'], 'product_id' => $_POST['product_id']])
                ->orWhere(['actor' => \Yii::$app->user->id, 'owner' => $_POST['actor'], 'product_id' => $_POST['product_id']])
                ->all();
        $msg = $query->from('message')
                ->where(['owner.id' => $_POST['actor'], 'actor.id' => \Yii::$app->user->id, 'product.id' => $_POST['product_id']])
                ->one();
        Yii::$app->mongodb->getCollection('message')->update(['_id' => (string) $msg['_id']], ['$set' => [
                'last_msg_count' => 0,
                'status' => 'online',
        ]]);
        $product = Product::find()->select(['_id', 'owner', 'title', 'slug', 'price', 'images', 'province', 'unit_of_calculation', 'weight', 'images', 'created_at'])->where(['_id' => $_POST['product_id']])->one();
        $seller = User::find()->select(['_id', 'address', 'fullname', 'category', 'trademark', 'garden_name', 'acreage', 'category', 'certificate', 'active', 'insurance_money'])->where(['_id' => $product->owner['id']])->one();
        return ['conversation' => $conversation, 'msg' => $msg, 'product' => $product, 'seller' => $seller];
    }

    public function seller($owner) {
        $seller = (object) $query->select(['owner', 'address', 'fullname', 'category', 'trademark', 'garden_name', 'acreage', 'category', 'certificate', 'active', 'insurance_money'])->from('user_info')->where(['owner' => $owner])->one();
        $category = [];
        foreach ($seller['category'] as $value) {
            $category[] = $value['title'];
        }
        $certificate = [];
        foreach ($seller['certificate'] as $value) {
            $certificate[] = $value['name'];
        }
        return [
        ];
    }

}
