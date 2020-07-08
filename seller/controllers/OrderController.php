<?php

namespace seller\controllers;

use Yii;
use yii\widgets\ActiveForm;
use common\models\Order;
use common\components\Constant;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\mongodb\Query;
use seller\models\ProductOrderForm;
use seller\models\OrderFilter;
use seller\models\OrderForm;

class OrderController extends ManagerController {

    public function init() {
        parent::init();
    }

    public function actionFilter() {
        $filter = new OrderFilter();
        $order = new Order();
        $dataProvider = $filter->fillter(Yii::$app->request->queryParams);
        $this->view->title = 'Đơn hàng của bạn';
        return $this->render('index', ['dataProvider' => $dataProvider, 'order' => $order]);
    }

    public function actionIndex() {
        $order = new Order();
        $dataProvider = new ActiveDataProvider([
            'query' => $order::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ORDER_PENDING])->orderBy('created_at DESC'),
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = 'Đơn hàng đang xử lý';

        return $this->render('index', ['dataProvider' => $dataProvider, 'order' => $order]);
    }

    public function actionSending() {
        $order = new Order();
        $dataProvider = new ActiveDataProvider([
            'query' => $order::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ORDER_SENDING])->orderBy('created_at DESC'),
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = 'Đơn hàng đang giao';

        return $this->render('index', ['dataProvider' => $dataProvider, 'order' => $order]);
    }

    public function actionUnsuccessful() {
        $order = new Order();
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ORDER_UNSUCCESSFUL])->orderBy('created_at DESC'),
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = 'Đơn hàng không thành công';

        return $this->render('index', ['dataProvider' => $dataProvider, 'order' => $order]);
    }

    public function actionFinish() {
        $order = new Order();
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ORDER_FINISH])->orderBy('created_at DESC'),
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = 'Đơn hàng đã hoàn thành';

        return $this->render('index', ['dataProvider' => $dataProvider, 'order' => $order]);
    }

    public function actionBlock() {
        $order = new Order();
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['owner.id' => \Yii::$app->user->id, 'status' => Constant::STATUS_ORDER_BLOCK])->orderBy('created_at DESC'),
            'pagination' => [
                'defaultPageSize' => 20
            ],
        ]);
        $this->view->title = 'Đơn hàng đã hủy';

        return $this->render('index', ['dataProvider' => $dataProvider, 'order' => $order]);
    }

    public function actionView($id) {
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query)->from('product_order')->where(['owner.id' => \Yii::$app->user->id, 'order.code' => (int) $id])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $this->view->title = 'Mã đơn hàng #' . $id;
        return $this->render('index', ['dataProvider' => $dataProvider, 'model' => $model]);
    }

    public function actionShipping($id) {
        $order = (new Query)->from('order')->where(['code' => (int) $id])->one();
        if (!$order) {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }
        $status = [];
        foreach ($order['product'] as $value) {
            $status[] = $value['status'];
        }

        if (!in_array(1, $status)) {
            return "Tất cả sản phẩm trong đơn hàng của bạn đã hết hàng.";
        }

        $model = new ProductOrderForm();
        $model->id = $id;
        return $this->renderAjax('shipping', ['model' => $model]);
    }

    public function actionUnsuccessfulform($id) {
        $model = new OrderForm();
        $order = (new Query)->from('order')->where(['code' => (int) $id])->one();
        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            foreach ($model['reason'] as $value) {
                if ($value != $model::OTHER_BLOCK) {
                    $data[] = $model->block()[$value];
                }
            }

            if (!empty($model['description'])) {
                $data[] = $model['description'];
            }

            if (!empty($data)) {
                //status
                Yii::$app->mongodb->getCollection('order')->update(['code' => (int) $id], [
                    'status' => Constant::STATUS_ORDER_UNSUCCESSFUL,
                    'content' => $data,
                ]);
                if ($order['count_seller'] <= 1) {
                    $content = 'Đơn hàng #' . $this->invoice($order['invoice'])['code'] . ' của bạn được giao không thành công.';
                } else {
                    $content = 'Một kiện hàng thuộc đơn hàng #' . $this->invoice($order['invoice'])['code'] . ' của bạn được giao không thành công.';
                }
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'buyer',
                    'owner' => $order['buyer']['id'],
                    'content' => $content,
                    'url' => Yii::$app->setting->get('siteurl') . '/invoice/view/' . $order['invoice'] . '#' . $order['code'],
                    'status' => 0,
                    'created_at' => time()
                ]);

                //mail
                Yii::$app->mongodb->getCollection('mail')->insert([
                    'order_id' => (string) $order['_id'],
                    'title' => $content,
                    'type' => 'order_failed',
                    'code' => $this->invoice($order['invoice'])['code'],
                    'layout' => 'order_failed',
                    'created_at' => time()
                ]);

                $this->unsuccessful($order);


                Yii::$app->session->setFlash('success', "Xử lý đơn hàng thành công");
                return $this->redirect(['sending']);
            } else {
                Yii::$app->session->setFlash('danger', "Xử lý đơn hàng thất bại. Vui lòng nhập lý do đơn hàng không thành công.");
                return $this->redirect(['sending']);
            }
        }
        return $this->renderAjax('/order/_unsuccessful', ['model' => $model]);
    }

    public function actionBlockform($id) {
        $model = new OrderForm(['code' => $id]);
        $order = (new Query)->from('order')->where(['code' => (int) $id])->one();
        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            foreach ($model['reason'] as $value) {
                if ($value != $model::OTHER_BLOCK) {
                    $data[] = $model->block()[$value];
                }
            }

            if (!empty($model['description'])) {
                $data[] = $model['description'];
            }

            if (!empty($data)) {
                //status
                Yii::$app->mongodb->getCollection('order')->update(['code' => (int) $id], [
                    'status' => Constant::STATUS_ORDER_BLOCK,
                    'content' => $data,
                ]);
                if ($order['count_seller'] <= 1) {
                    $content = 'Đơn hàng #' . $this->invoice($order['invoice'])['code'] . ' của bạn đã được hủy trên hệ thống.';
                } else {
                    $content = 'Một kiện hàng thuộc đơn hàng #' . $this->invoice($order['invoice'])['code'] . ' của bạn đã được hủy trên hệ thống.';
                }
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'buyer',
                    'owner' => $order['buyer']['id'],
                    'content' => $content,
                    'url' => Yii::$app->setting->get('siteurl') . '/invoice/view/' . $order['invoice'] . '#' . $order['code'],
                    'status' => 0,
                    'created_at' => time()
                ]);

                //mail
                Yii::$app->mongodb->getCollection('mail')->insert([
                    'order_id' => (string) $order['_id'],
                    'title' => $content,
                    'type' => 'order_cancel',
                    'code' => (int) $this->invoice($order['invoice'])['code'],
                    'layout' => 'order_cancel',
                    'created_at' => time()
                ]);

                Yii::$app->session->setFlash('success', "Hủy đơn hàng thành công");
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('danger', "Hủy đơn hàng thất bại. Vui lòng nhập lý do hủy đơn hàng.");
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('/order/_block', ['model' => $model]);
    }

    public function actionFinishform($id) {
        $model = new OrderForm(['code' => $id]);
        $order = (new Query)->from('order')->where(['code' => (int) $id])->one();

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if (!empty($model['level_satisfaction'])) {
                $data['level_satisfaction'] = (int) $model['level_satisfaction'];
            } else {
                Yii::$app->session->setFlash('danger', "Bạn chưa chọn mức độ hài lòng của bạn đối với khách hàng.Vui lòng chọn mức độ hài lòng của bạn");
                return $this->redirect(['sending']);
            }

            if (!empty($model['description'])) {
                $data['description'] = $model['description'];
            }

            $data['owner'] = [
                'id' => Yii::$app->user->id,
                'fullname' => Yii::$app->user->identity->fullname,
                'username' => Yii::$app->user->identity->username,
                'garden_name' => Yii::$app->user->identity->garden_name,
                'province' => Yii::$app->user->identity->province,
                'district' => Yii::$app->user->identity->district,
                'ward' => Yii::$app->user->identity->ward,
                'address' => Yii::$app->user->identity->address
            ];

            $data['buyer'] = $order['buyer'];
            $data['order_id'] = (string) $order['_id'];
            $data['product'] = $order['product'];

            if (time() >= $order['date_end']) {

                foreach ($order['product'] as $value) {

                    if ($value['status'] == 1) {
                        Yii::$app->mongodb->getCollection('static')->insert([
                            'owner' => $order['owner']['id'],
                            'product' => [
                                'id' => $value['id'],
                                'slug' => $value['slug'],
                                'title' => $value['title'],
                                'unit' => $value['unit']
                            ],
                            'province' => [
                                'id' => $order['province_id'],
                                'name' => $order['buyer']['province'],
                                'unit' => $value['unit']
                            ],
                            'price' => (int) $value['price'],
                            'quantity' => (int) $value['quantity'],
                            'created_at' => time(),
                            'updated_at' => time(),
                        ]);
                        $product = (new Query)->from('product')->where(['_id' => $value['id']])->one();

                        if ($value['type'] == 0 && !empty($product['approx'])) {
                            $qtt_stock = $product['quantity_stock_temp'] - (int) $value['quantity'];
                            $approx = [];
                            foreach ($product['approx'] as $key => $val) {
                                if ((int) $val['quantity_min'] <= $qtt_stock) {
                                    $approx[] = [
                                        "quantity_min" => (int) $val['quantity_min'],
                                        "quantity_max" => (int) $val['quantity_max'] >= $qtt_stock ? (int) $qtt_stock : (int) $val['quantity_max'],
                                        "price" => (int) $val['price']
                                    ];
                                }
                            }
                            Yii::$app->mongodb->getCollection('product')->update(['_id' => (string) $product['_id']], [
                                'approx' => $approx,
                                'quantity_stock_temp' => $qtt_stock
                            ]);
                        }
                        if ($value['type'] > 0 && !empty($product['classify'])) {

                            foreach ($product['classify'] as $k => $val) {
                                if (!empty($val['frame']) && $val['id'] == $value['type']) {
                                    $frame = [];
                                    $qtt_stock = $val['quantity_stock_temp'] - (int) $value['quantity'];
                                    foreach ($val['frame'] as $f) {
                                        if ((int) $f['quantity_min'] <= $qtt_stock) {
                                            $frame[] = [
                                                "quantity_min" => (int) $f['quantity_min'],
                                                "quantity_max" => (int) $f['quantity_max'] >= $qtt_stock ? (int) $qtt_stock : (int) $f['quantity_max'],
                                                "price" => (int) $f['price']
                                            ];
                                        }
                                    }

                                    Yii::$app->mongodb->getCollection('product')->update(['_id' => (string) $product['_id']], ['$set' => [
                                            'classify.' . $k . '.frame' => $frame,
                                            'classify.' . $k . '.quantity_stock_temp' => $qtt_stock
                                    ]]);
                                }
                            }
                        }
                    }
                }

                Yii::$app->mongodb->getCollection('order')->update(['_id' => (string) $order['_id']], ['status' => (int) Constant::STATUS_ORDER_FINISH]);

                //mail
                if ($order['count_seller'] <= 1) {
                    $content = 'Đơn hàng #' . $this->invoice($order['invoice'])['code'] . ' của bạn đã được giao thành công';
                } else {
                    $content = 'Một kiện hàng thuộc đơn hàng #' . $this->invoice($order['invoice'])['code'] . ' của bạn đã được giao thành công';
                }
                Yii::$app->mongodb->getCollection('mail')->insert([
                    'order_id' => (string) $order['_id'],
                    'title' => $content,
                    'type' => 'order_complete',
                    'code' => (int) $this->invoice($order['invoice'])['code'],
                    'layout' => 'order_complete',
                    'created_at' => time()
                ]);

                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'buyer',
                    'owner' => $order['buyer']['id'],
                    'content' => $content,
                    'url' => Yii::$app->setting->get('siteurl') . '/invoice/view/' . $order['invoice'] . '#' . $order['code'],
                    'status' => 0,
                    'created_at' => time()
                ]);

                if (!empty($data)) {
                    Yii::$app->mongodb->getCollection('review_buyer')->insert($data);
                    Yii::$app->session->setFlash('success', "Xử lý đơn hàng thành công");
                    return $this->redirect(['sending']);
                }
            } else {
                Yii::$app->session->setFlash('warning', "Sản phẩm của bạn hình như chưa đến tay khách hàng! Bạn không thể hoàn thành đơn hàng trước thời gian dự kiến (" . date('d/m/Y - H:i:s', $order['date_end']) . ") mà khách hàng có thể nhận hàng!");
                return $this->redirect(['sending']);
            }
        }

        return $this->renderAjax('/order/finish', ['model' => $model, 'order' => $order]);
    }

    public function actionRemove($id) {
        $order = (new Query)->from('order')->where(['code' => (int) $id])->one();
        if (!$order) {
            throw new NotFoundHttpException('Trang này không tồn tại trong hệ thống.');
        }

        Yii::$app->mongodb->getCollection('order')->remove(['code' => (int) $id]);
        return $this->redirect(['index']);
    }

    public function unsuccessful($order) {

        foreach ($order['product'] as $value) {
            $product = (new Query)->from('product')->where(['_id' => $value['id']])->one();
            if ($value['status'] == 1) {
                $data = [];
                if (!empty($product['classify'])) {
                    $key = array_search($value['type'], array_column($product['classify'], 'id'));
                    $classify = $product['classify'][$key];
                    $qtt = $classify['quantity_purchase'];
                    $qtt_purchase_total = $classify['quantity_purchase_total'];
                    $remain_quantity = $classify['quantity_stock'] + (int) $value['quantity'];
                    $data['classify.' . $key . '.quantity_purchase_total'] = $qtt_purchase_total - (int) $value['quantity'];
                    $data['classify.' . $key . '.quantity_purchase'] = $qtt - (int) $value['quantity'];
                    $data['classify.' . $key . '.quantity_stock'] = $classify['quantity_stock'] + (int) $value['quantity'];
                    $data['classify.' . $key . '.status'] = 1;
                    if (!empty($classify['frame'])) {
                        foreach ($classify['frame'] as $val) {
                            if ((int) $val['quantity_min'] <= $remain_quantity && $remain_quantity <= (int) $val['quantity_max']) {
                                $data['classify.' . $key . '.price_min'] = (int) $val['price'];
                                $data['classify.' . $key . '.price_max'] = (int) $product['classify'][$key]['price_max'];
                            }
                        }
                    }

                    //notification
                    Yii::$app->mongodb->getCollection('notification')->insert([
                        'type' => 'seller',
                        'owner' => \Yii::$app->user->id,
                        'content' => 'Đơn hàng #<b>' . $order['code'] . '</b> giao không thành công.Sản phẩm <b>' . $product['title'] . ' ' . $product['classify'][$key]['kind'] . '</b> còn lại ' . $data['classify.' . $key . '.quantity_stock'] . ' ' . $product['unit'],
                        'url' => Yii::$app->setting->get('siteurl_seller') . '/product/filter?keywords=' . $product['_id'],
                        'status' => 0,
                        'created_at' => time()
                    ]);
                } else {
                    $qtt = $product['quantity_purchase'];
                    $qtt_purchase_total = $product['quantity_purchase_total'];
                    $remain_quantity = $product['quantity_stock'] + (int) $value['quantity'];
                    $data['quantity_purchase'] = $qtt - (int) $value['quantity'];
                    $data['quantity_stock'] = $product['quantity_stock'] + (int) $value['quantity'];
                    $data['quantity_purchase_total'] = $qtt_purchase_total - (int) $value['quantity'];
                    if (!empty($product['approx'])) {
                        foreach ($product['approx'] as $val) {
                            if ((int) $val['quantity_min'] <= $data['quantity_stock'] && $data['quantity_stock'] <= (int) $val['quantity_max']) {
                                $data['price']['min'] = $val['price'];
                                $data['price']['max'] = $product['price']['max'];
                            }
                        }
                    }

                    //notification
                    Yii::$app->mongodb->getCollection('notification')->insert([
                        'type' => 'seller',
                        'owner' => \Yii::$app->user->id,
                        'content' => 'Đơn hàng #<b>' . $order['code'] . '</b> giao không thành công.Sản phẩm <b>' . $product['title'] . '</b> còn lại ' . $data['quantity_stock'] . ' ' . $product['unit'],
                        'url' => Yii::$app->setting->get('siteurl_seller') . '/product/filter?keywords=' . $product['_id'],
                        'status' => 0,
                        'created_at' => time()
                    ]);
                }
                $data['status'] = Constant::STATUS_ACTIVE;

                $order_product = (new Query)->from('order')->where(['product.id' => (string) $value['id'], 'status' => Constant::STATUS_ORDER_PENDING])->all();

                foreach ($order_product as $item_order) {
                    foreach ($item_order['product'] as $item_product) {
                        if ($item_product['id'] == $value['id'] && $item_product['quantity'] <= $remain_quantity) {
                            $k = array_search($item_product['id'], array_column($item_order['product'], 'id'));
                            Yii::$app->mongodb->getCollection('order')->update(['_id' => (string) $item_order['_id']], ['$set' => [
                                    'product.' . $k . '.status' => 1,
                            ]]);
                        }
                    }
                }
                Yii::$app->mongodb->getCollection('product')->update(['_id' => $value['id']], $data);
            } else if ($value['status'] == 0) {
                if ($value['quantity'] <= $remain_quantity) {
                    $k = array_search($value['id'], array_column($order['product'], 'id'));
                    Yii::$app->mongodb->getCollection('order')->update(['_id' => (string) $order['_id']], ['$set' => [
                            'product.' . $k . '.status' => 1,
                    ]]);
                }
            }
        }
    }

    public function invoice($id) {
        return (new Query)->from('invoice')->where(['_id' => $id])->one();
    }

}
