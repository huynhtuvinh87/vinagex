<?php

namespace seller\controllers;

use Yii;
use seller\models\PaymentForm;
use yii\widgets\ActiveForm;
use yii\mongodb\Query;

class PaymentController extends ManagerController {

    public function init() {
        parent::init();
    }

    public function actionIndex() {
        // $model = (new Query)->from('payment')->where(['owner.id'=>Yii::$app->user->id])->one();
        $model = (new Query)->from('user')->where(['_id' => Yii::$app->user->id])->one();
        $this->view->title = 'Thông tin thanh toán';
        if (Yii::$app->request->post()) {
            $id = Yii::$app->request->post('id');
            $title = Yii::$app->request->post('title');
            $note = Yii::$app->request->post('note');
            $data = [
                'id' => $id,
                'title' => $title,
                'note' => $note,
            ];

            if (!empty(Yii::$app->request->post('percent'))) {
                $data['percent'] = (int) Yii::$app->request->post('percent');
            }

            $payment = [];
            if (!empty($model['payment'])) {
                foreach ($model['payment'] as $key => $value) {
                    $payment[] = $value['id'];
                }
            }

            if (in_array($id, $payment)) {
                $k = array_search($id, array_column($model['payment'], 'id'));
                $data = $model['payment'][$k];
                return Yii::$app->mongodb->getCollection('user')->update(['_id' => Yii::$app->user->id], ['$pull' => [
                                'payment' => $data
                ]]);
            } else {
                return Yii::$app->mongodb->getCollection('user')->update(['_id' => Yii::$app->user->id], ['$push' => ['payment' => $data]]);
            }
        }

        return $this->render('index', ['model' => $model]);
    }

    public function actionCreate() {
        $model = new PaymentForm();

        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            $model->save();
            Yii::$app->session->setFlash('success', "Thêm mới thành công.");
            return $this->redirect(['index']);
        }
        return $this->renderAjax('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $model = new PaymentForm(['bank_id' => $id]);

        if ($model->owner_id == Yii::$app->user->id) {
            if ($model->load(Yii::$app->request->post())) {

                if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }

                $model->save();
                Yii::$app->session->setFlash('success', "Chỉnh sửa thành công.");
                return $this->redirect(['index']);
            }
            return $this->renderAjax('update', ['model' => $model]);
        }
    }

    public function actionDelete($id) {
        $model = (new Query)->from('payment')->where(['bank.id' => $id])->one();
        if ($model['owner']['id'] == Yii::$app->user->id) {
            $key = array_search($id, array_column($model['bank'], 'id'));
            $bank = $model['bank'][$key];
            if (Yii::$app->request->post()) {
                Yii::$app->mongodb->getCollection('payment')->update(['_id' => (string) $model['_id']], ['$pull' => ['bank' => $bank]]);
                Yii::$app->session->setFlash('success', "Xóa thành công.");
                return $this->redirect('/payment/index');
            }
            return $this->renderAjax('delete', ['bank' => $bank]);
        }
    }

}
