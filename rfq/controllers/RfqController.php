<?php

namespace rfq\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\mongodb\Query;
use common\components\Constant;

/**
 * Rfq controller
 */
class RfqController extends Controller {

    public function init() {
        parent::init();
        $this->enableCsrfValidation = false;
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

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => (new Query)->from('rfq')->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->view->title = 'Danh sách bạn yêu cầu';
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionApply($id) {
        $query = (new Query)->from('rfq')->where(['_id' => $id])->one();
        $model = new \rfq\models\ApplyForm(['id' => $id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Bạn đã đặt thành công.');
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        return $this->renderAjax('apply', ['model' => $model, 'rfq' => $query]);
    }

    public function actionDelete($id) {
        $query = (new Query)->from('rfq')->where(['_id' => $id])->one();
        if ($query) {
            Yii::$app->mongodb->getCollection('rfq')->remove(['_id' => $id]);
            Yii::$app->session->setFlash('success', 'Xóa thành công');
        }
        return $this->redirect(['manager/rfq']);
    }

    public function actionStop($id) {
        $query = (new Query)->from('rfq')->where(['_id' => $id])->one();
        if ($query) {
            Yii::$app->mongodb->getCollection('rfq')->update(['_id' => $query['_id']], ['status' => Constant::STATUS_STOP]);
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionView($id) {
        $rfq = (new Query)->from('rfq')->where(['_id' => $id])->one();
        if (!$rfq) {
            return $this->goBack();
        }
        $rfq_category = new ActiveDataProvider([
            'query' => (new Query)->from('rfq')->where(['product_type.id' => $rfq['product_type']['id']])->andWhere(['NOT IN', '_id', $id])->orderBy('created_at DESC'),
            'pagination' => [
                'defaultPageSize' => 5,
            ],
        ]);
        $rfq_user = new ActiveDataProvider([
            'query' => (new Query)->from('rfq')->where(['owner.id' => $rfq['owner']['id']])->andWhere(['NOT IN', '_id', $id])->orderBy('created_at DESC'),
            'pagination' => [
                'defaultPageSize' => 5,
            ],
        ]);
        $this->view->title = Yii::t('rfq', $rfq['title']);
        return $this->render('view', ['rfq' => $rfq, 'rfq_category' => $rfq_category, 'rfq_user' => $rfq_user]);
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

}
