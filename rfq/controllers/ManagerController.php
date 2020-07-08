<?php

namespace rfq\controllers;

use Yii;
use yii\web\Controller;
use rfq\models\RfqForm;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use common\components\Constant;

/**
 * Rfq controller
 */
class ManagerController extends Controller {

    public function init() {
        parent::init();
        $this->enableCsrfValidation = false;
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['rfp', 'apply', 'offer', 'deny', 'cancel', 'create', 'update', 'complete'],
                'rules' => [
                    [
                        'actions' => ['rfp', 'apply', 'offer', 'deny', 'cancel', 'create', 'update', 'complete'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionRfq() {
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query)->from('rfq')->where(['owner.id' => \Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC, 'status' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = Yii::t('rfq', 'Danh sách yêu cầu của bạn');
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionApply() {
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query)->from('rfq_offer')->where(['actor.id' => \Yii::$app->user->id])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = Yii::t('rfq', 'Báo giá của bạn');
        return $this->render('apply', ['dataProvider' => $dataProvider]);
    }

    public function actionOffer($id) {
        $rfq = (new Query)->from('rfq')->where(['_id' => $id, 'owner.id' => \Yii::$app->user->id])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query)->from('rfq_offer')->where(['rfq.id' => $id, 'owner.id' => \Yii::$app->user->id])->orderBy(['status' => SORT_ASC, 'price' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = Yii::t('rfq', 'Chi tiết báo giá của sản phẩm');
        return $this->render('offer', ['dataProvider' => $dataProvider, 'rfq' => $rfq]);
    }

    public function actionComplete($id) {
        $query = (new Query)->from('rfq_offer')->where(['_id' => $id])->one();
        if ($query) {
            Yii::$app->mongodb->getCollection('rfq_offer')->update(['rfq.id' => $query['rfq']['id'], 'status' => Constant::STATUS_PENDING], ['status' => Constant::STATUS_DENY]);
            Yii::$app->mongodb->getCollection('rfq_offer')->update(['_id' => $id], ['status' => Constant::STATUS_ACTIVE]);
            Yii::$app->mongodb->getCollection('rfq')->update(['_id' => $query['rfq']['id']], ['status' => Constant::STATUS_FINISH]);
            Yii::$app->session->setFlash('success', 'Đồng ý báo giá thành công');
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionCancel($id) {
        Yii::$app->mongodb->getCollection('rfq_offer')->update(['_id' => $id], ['status' => Constant::STATUS_CANCEL]);
        Yii::$app->session->setFlash('success', 'Hủy thành công');
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionDeny($id) {
        Yii::$app->mongodb->getCollection('rfq_offer')->update(['_id' => $id], ['status' => Constant::STATUS_DENY]);
        Yii::$app->session->setFlash('success', 'Từ chối thành công');
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionCreate() {
        $model = new RfqForm;
        if ($model->load(yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['rfq']);
        }
        return $this->render('create', [
                    'model' => $model
        ]);
    }

    public function actionUpdate($id) {
        $model = new RfqForm(['id' => $id]);
        if ($model->load(yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['rfq']);
        }
        return $this->render('update', [
                    'model' => $model
        ]);
    }

    public function actionMove($id) {
        $query = $this->findModel($id);
        if ($query) {
            $data = [
                'title' => $query['title'],
                'content' => $query['content'],
                'category_id' => $query['category']['id'],
                'product_type' => $query['product_type']['id'],
                'quantity' => $query['quantity'],
                'price' => $query['price'],
                'images' => $query['images'],
                'date_start' => \Yii::$app->formatter->asDatetime($query['date_start'], "php:d/m/Y"),
                'date_end' => \Yii::$app->formatter->asDatetime($query['date_end'], "php:d/m/Y"),
            ];
            $model = new RfqForm($data);
            return $this->render('create', [
                        'model' => $model
            ]);
        }
    }

    public function actionDelete($id) {
        $query = (new Query)->from('rfq')->where(['_id' => $id])->one();
        if ($query) {
            Yii::$app->mongodb->getCollection('rfq')->remove(['_id' => $id]);
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = (new Query)->from('rfq')->where(['_id' => $id])->one()) !== null) {
            return $model;
        } else {
            $this->goHome();
        }
    }

}
