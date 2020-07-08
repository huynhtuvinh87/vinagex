<?php

namespace seller\controllers;

use Yii;
use yii\web\Controller;
use common\models\OrderStatus;
use common\models\SendMail;
use common\models\Setting;
use common\components\Constant;
use yii\mongodb\Query;
use seller\models\ProductOrderForm;
use common\models\Comment;

class AjaxController extends Controller {

    public $_setting;

    public function init() {
        parent::init();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->_setting = Setting::findOne(['key' => 'config']);
    }

    public function actionDeleteimage() {
        $filepath = \Yii::getAlias("@cdn/web/" . $_POST['path']);
        return unlink($filepath);
    }

    public function actionUpload() {
        if (!file_exists(\Yii::getAlias("@cdn/web/images/products/seller_" . \Yii::$app->user->id))) {
            mkdir(\Yii::getAlias("@cdn/web/images/products/seller_" . \Yii::$app->user->id), 0777, true);
        }
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['file']));
        $name = uniqid() . '.png';
        $filepath = \Yii::getAlias("@cdn/web/images/products/seller_" . \Yii::$app->user->id) . '/' . $name;
        file_put_contents($filepath, $data);
        list($width, $height, $type, $attr) = getimagesize($filepath);
//        if ($width >= 450 && $height >= 450) {
            return [
                'src' => Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/products/seller_' . \Yii::$app->user->id . '/' . $name . '&size=350x350',
                'img_300x250' => Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/products/seller_' . \Yii::$app->user->id . '/' . $name . '&size=300x250',
                'path' => 'images/products/seller_' . \Yii::$app->user->id . '/' . $name,
            ];
//        } else {
//            return ['error' => 'Bạn tải hình ảnh không đúng kích thước theo quy định!'];
//            unlink($filepath);
//        }
    }

    public function actionSellerupload() {
        if (!file_exists(\Yii::getAlias("@cdn/web/images/sellers/seller_" . \Yii::$app->user->id))) {
            mkdir(\Yii::getAlias("@cdn/web/images/sellers/seller_" . \Yii::$app->user->id), 0777, true);
        }
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['file']));
        $name = uniqid() . '.png';
        $filepath = \Yii::getAlias("@cdn/web/images/sellers/seller_" . \Yii::$app->user->id) . '/' . $name;
        file_put_contents($filepath, $data);
        list($width, $height, $type, $attr) = getimagesize($filepath);
//        if ($width >= 450 && $height >= 450) {
            return [
                'src' => Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/sellers/seller_' . \Yii::$app->user->id . '/' . $name . '&size=350x300',
                'path' => 'images/sellers/seller_' . \Yii::$app->user->id . '/' . $name,
            ];
//        } else {
//            return ['error' => 'Bạn tải hình ảnh không đúng kích thước theo quy định!'];
//            unlink($filepath);
//        }
    }

    public function actionDistrict($id) {
        $model = Yii::$app->province->getDistricts($id);
        return $model;
    }

    public function actionWard($id) {
        $model = Yii::$app->province->getWards($id);
        return $model;
    }

    public function actionShipping($id) {
        $model = new ProductOrderForm();
        $model->id = $id;
        $order = (new Query)->from('order')->where(['code' => (int) $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $date_begin = \Yii::$app->formatter->asDatetime(str_replace('/', '-', $model->date_begin), "php:Y-m-d");
                $data['date_begin'] = strtotime($date_begin . ' ' . $model->time_begin);
                if ($model->date_end) {
                    $date_begin = \Yii::$app->formatter->asDatetime(str_replace('/', '-', $model->date_end), "php:Y-m-d");
                    $data['date_end'] = strtotime($date_begin . ' ' . $model->time_end);
                }
                //order status
                $data = array_merge($data, ['status' => Constant::STATUS_ORDER_SENDING]);

                $invoice = (new Query)->from('invoice')->where(['_id' => $order['invoice']])->one();
                if ($order['count_seller'] <= 1) {
                    $content = 'Đơn hàng: #' . $invoice['code'] . ' đang được giao. Thời gian dự kiến nhận hàng ' . date('h:i - d/m/Y', $data['date_end']);
                } else {
                    $content = 'Kiện hàng thuộc đơn hàng: #' . $invoice['code'] . ' đang được giao. Thời gian dự kiến nhận hàng ' . date('h:i - d/m/Y', $data['date_end']);
                }
                //transport

                $product_name = [];
                foreach ($order['product'] as $p) {
                    $product_name[] = $p['title'];
                }
                if(!empty($order['owner']['transport_code'])){
                    $transport_user = Yii::$app->mongodb1->getCollection('user')->findOne(['transport_code' => $order['owner']['transport_code']]);
                }
                if (!empty($transport_user)) {
                    if (!empty($model->carType) && !empty($model->mass) && !empty($model->transport_price) && !empty($model->unit)) {
                        $car = Yii::$app->mongodb1->getCollection('car_type')->findOne(['_id' => $model->carType]);
                        Yii::$app->mongodb1->getCollection('goods')->insert([
                            'title' => implode(', ', $product_name),
                            'car' => [
                                'id' => (string) $car['_id'],
                                'name' => $car['name'],
                                'parent_id' => $car['parent_id']
                            ],
                            'product' => $order['product'],
                            'location_start' => $order['owner']['district']['name'] . ', ' . $order['owner']['province']['name'],
                            'location_end' => $order['buyer']['district'] . ', ' . $order['buyer']['province'],
                            'date' => $data['date_begin'],
                            'mass' => (int) $model->mass,
                            'unit' => $model->unit,
                            'price' => (int) $model->transport_price,
                            'status' => Constant::STATUS_ACTIVE,
                            'owner' => [
                                'id' => \Yii::$app->user->id,
                                'fullname' => \Yii::$app->user->identity->fullname,
                                'phone' => \Yii::$app->user->identity->phone
                            ],
                            'vat' => $model->vat,
                            'created_at' => time()
                        ]);
                    }
                }

                //mail
                Yii::$app->mongodb->getCollection('mail')->insert([
                    'order_id' => (string) $order['_id'],
                    'title' => $content,
                    'type' => 'order_sending',
                    'code' => (int) $invoice['code'],
                    'layout' => 'order_sending',
                    'created_at' => time()
                ]);
                //notification

                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'buyer',
                    'owner' => $order['buyer']['id'],
                    'content' => $content,
                    'url' => Yii::$app->setting->get('siteurl') . '/invoice/view/' . $order['invoice'] . '#' . $order['code'],
                    'status' => 0,
                    'created_at' => time()
                ]);

                Yii::$app->mongodb->getCollection('order')->update(['code' => (int) $id], $data);

                foreach ($order['product'] as $value) {
                    $data = [];
                    if ($value['status'] == 1) {
                        $product = (new Query)->from('product')->where(['_id' => $value['id']])->one();
                        if ($product['price_type'] == 3) {
                            $this->pendingClassify($id, $value, $product);
                        } else {
                            $this->pending($id, $value, $product);
                        }
                    }
                }
            } else {
                echo 'Khoản cách thời gian không hợp lý';
                exit;
            }
        }
    }

    public function pendingClassify($id, $value, $product) {
        $key = array_search($value['type'], array_column($product['classify'], 'id'));
        $classify = $product['classify'][$key];
        $qtt = !empty($classify['quantity_purchase']) ? $classify['quantity_purchase'] : 0;
        $qtt_purchse_total = !empty($classify['quantity_purchase_total']) ? $classify['quantity_purchase_total'] : 0;
        $remain_quantity = $classify['quantity_stock'] - (int) $value['quantity'];
        $data['classify.' . $key . '.quantity_purchase'] = $qtt + (int) $value['quantity'];
        $data['classify.' . $key . '.quantity_stock'] = $remain_quantity;
        $data['classify.' . $key . '.quantity_purchase_total'] = $qtt_purchse_total + (int) $value['quantity'];

        if (!empty($classify['frame'])) {
            foreach ($classify['frame'] as $val) {
                if ((int) $val['quantity_min'] <= $remain_quantity && $remain_quantity <= (int) $val['quantity_max']) {
                    $data['classify.' . $key . '.price_min'] = (int) $val['price'];
                    $data['classify.' . $key . '.price_max'] = (int) $product['classify'][$key]['price_max'];
                }
            }
        }
        if ($remain_quantity < $classify['quantity_min']) {
            $data['classify.' . $key . '.status'] = 0;
            foreach ($product['classify'] as $item) {
                $status[] = $item['status'];
            }
            $count = array_count_values($status);
            if (!empty($count[1]) && $count[1] == 1) {
                $data['status'] = Constant::STATUS_BLOCK;

                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'seller',
                    'owner' => \Yii::$app->user->id,
                    'content' => 'Sản phẩm <b>' . $product['title'] . '</b> đã hết hàng.',
                    'url' => Yii::$app->setting->get('siteurl_seller') . '/product/filter?keywords=' . $product['_id'],
                    'status' => 0,
                    'created_at' => time()
                ]);
            }

            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'seller',
                'owner' => \Yii::$app->user->id,
                'content' => 'Đơn hàng #<b>' . $id . '</b> giao thành công.Sản phẩm <b>' . $product['title'] . ' ' . $product['classify'][$key]['kind'] . '</b> đã hết hàng',
                'url' => Yii::$app->setting->get('siteurl_seller') . '/product/filter?keywords=' . $product['_id'],
                'status' => 0,
                'created_at' => time()
            ]);

            $msg_danger = "<b>Sản phẩm: " . $product['title'] . (($value['type'] != 0) ? " Loại " . $value['type'] : "") . " đã hết hàng<br>";
            Yii::$app->session->setFlash('danger', $msg_danger);
        }

        $order_product = (new Query)->from('order')->where(['product.id' => $value['id'], 'status' => Constant::STATUS_ORDER_PENDING])->all();
        foreach ($order_product as $item_order) {
            foreach ($item_order['product'] as $item_product) {
                if (($item_product['id'] == $value['id'] && $item_product['quantity'] > $remain_quantity) && $item_product['status'] == 1 && $item_product['type'] == $value['type']) {
                    $k = array_search($item_product['id'], array_column($item_order['product'], 'id'));
                    Yii::$app->mongodb->getCollection('order')->update(['_id' => (string) $item_order['_id']], ['$set' => [
                            'product.' . $k . '.status' => 0,
                    ]]);
                }
            }
        }

        Yii::$app->mongodb->getCollection('product')->update(['_id' => $value['id']], ['$set' => $data]);
        Yii::$app->session->setFlash('success', "Đơn hàng: #<strong>" . $id . "</strong> đang được giao");
        return $this->redirect('/order/index');
    }

    public function pending($id, $value, $product) {
        $qtt = !empty($product['quantity_purchase']) ? $product['quantity_purchase'] : 0;
        $qtt_purchse_total = !empty($product['quantity_purchase_total']) ? $product['quantity_purchase_total'] : 0;
        $remain_quantity = $product['quantity_stock'] - (int) $value['quantity'];
        $data['quantity_purchase'] = $qtt + (int) $value['quantity'];
        $data['quantity_stock'] = $product['quantity_stock'] - (int) $value['quantity'];
        $data['quantity_purchase_total'] = $qtt_purchse_total + (int) $value['quantity'];

        if ($remain_quantity < $product['quantity_min']) {
            $data['status'] = Constant::STATUS_BLOCK;

            Yii::$app->mongodb->getCollection('notification')->insert([
                'type' => 'seller',
                'owner' => \Yii::$app->user->id,
                'content' => 'Sản phẩm <b>' . $product['title'] . '</b> đã hết hàng.',
                'url' => Yii::$app->setting->get('siteurl_seller') . '/product/filter?keywords=' . $product['_id'],
                'status' => 0,
                'created_at' => time()
            ]);

            $msg_danger = "<b>Sản phẩm: " . $product['title'] . (($value['type'] != 0) ? " Loại " . $value['type'] : "") . " đã hết hàng<br>";
            Yii::$app->session->setFlash('danger', $msg_danger);
        }

        $order_product = (new Query)->from('order')->where(['product.id' => $value['id'], 'status' => Constant::STATUS_ORDER_PENDING])->all();
        foreach ($order_product as $item_order) {
            foreach ($item_order['product'] as $item_product) {
                if (($item_product['id'] == $value['id'] && $item_product['quantity'] > $remain_quantity) && $item_product['status'] == 1 && $item_product['type'] == $value['type']) {
                    $k = array_search($item_product['id'], array_column($item_order['product'], 'id'));
                    Yii::$app->mongodb->getCollection('order')->update(['_id' => (string) $item_order['_id']], ['$set' => [
                            'product.' . $k . '.status' => 0,
                    ]]);
                }
            }
        }

        if (!empty($product['approx'])) {
            foreach ($product['approx'] as $key => $val) {
                if ((int) $val['quantity_min'] <= $data['quantity_stock'] && $data['quantity_stock'] <= (int) $val['quantity_max']) {
                    $data['price']['min'] = $val['price'];
                    $data['price']['max'] = $product['price']['max'];
                }
            }
        }

        Yii::$app->mongodb->getCollection('product')->update(['_id' => $value['id']], ['$set' => $data]);
        Yii::$app->session->setFlash('success', "Đơn hàng: #<strong>" . $id . "</strong> đang được giao");
        return $this->redirect('/order/index');
    }

    public function actionComment() {
        $data = [
            'id' => (string) new \MongoDB\BSON\ObjectID(),
            'ip' => Yii::$app->getRequest()->getUserIP(),
            'sex' => "",
            'id_owner' => \Yii::$app->user->id,
            'name' => \Yii::$app->user->identity->garden_name,
            'email' => \Yii::$app->user->identity->email,
            'content' => $_POST['content'],
            'status' => Comment::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ];
        Yii::$app->mongodb->getCollection('comment')->update(['_id' => $_POST['comment_id']], ['$push' => ['answers' => $data]]);
        Yii::$app->mongodb->getCollection('comment')->update(['_id' => $_POST['comment_id']], ['$set' => [
                'count_answer' => (int) Comment::findOne($_POST['comment_id'])->count_answer + 1,
        ]]);
        return TRUE;
    }

    public function actionCommentstatus() {
        $model = Comment::findOne($_POST['comment_id']);

        Yii::$app->mongodb->getCollection('comment')->update(['_id' => $_POST['comment_id']], ['$set' => [
                'answers.' . $_POST['key'] . '.status' => 2
        ]]);

        $owner = $model->answers[$_POST['key']];
        Yii::$app->mongodb->getCollection('notification')->insert([
            'type' => 'buyer',
            'owner' => $owner['id_owner'],
            'content' => 'Bình luận sản phẩm <b>' . $model->product['title'] . '</b> của bạn đã được duyệt.',
            'url' => Yii::$app->setting->get('siteurl') . '/' . $model->product['slug'] . '-' . $model->product['id'] . '#section-comment',
            'status' => 0,
            'created_at' => time()
        ]);

        return TRUE;
    }

}
