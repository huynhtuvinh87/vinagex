<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\web\NotFoundHttpException;
use backend\components\BackendController;
use common\components\Constant;

class SellerController extends BackendController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return parent::behaviors();
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $query = User::find()->where(['status' => User::STATUS_NOACTIVE, 'role' => User::ROLE_SELLER]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
        ]);
        $this->view->title = 'Nhà vườn chưa duyệt';
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionActive() {
        $query = User::find()->where(['status' => User::STATUS_ACTIVE, 'role' => User::ROLE_SELLER]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
        ]);
        $this->view->title = 'Nhà vườn đã duyệt';
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->delete();
        \Yii::$app->getSession()->setFlash('success', 'Xóa thành công');
        return $this->redirect([User::STATUS_NOACTIVE == $model->status ? 'index' : 'active']);
    }

    public function actionView($id) {
        $model = User::findOne($id);
        $data = [];
        if ($model->load(Yii::$app->request->post())) {
            $data['active'] = $model->active;
            $data['insurance_money'] = $model->insurance_money;
            $data['status'] = (int) $model->status;
            if(empty($model->insurance_money)){
                $data['active']['insurance_money'] = Constant::STATUS_NOACTIVE;
            }
            $data['public'] = (int) $model->public;
            $reason = [];
            if ((int) $model->public == User::PUBLIC_ACTIVE) {
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'seller',
                    'owner' => $id,
                    'content' => '<b>Tài khoản bán hàng của bạn mới được duyệt</b>',
                    'url' => Yii::$app->setting->get('siteurl_seller') . '/seller/index',
                    'status' => 0,
                    'created_at' => time()
                ]);
                Yii::$app->mongodb->getCollection('mail')->insert([
                    'title' => 'Tài khoản của bạn mới được duyệt',
                    'type' => 'seller',
                    'actor' => $id,
                    'layout' => 'seller_active',
                    'created_at' => time()
                ]);
            } else {
                Yii::$app->mongodb->getCollection('notification')->insert([
                    'type' => 'seller',
                    'owner' => $id,
                    'content' => '<b>Tài khoản bán hàng của bạn không đủ yêu cầu để chúng tôi duyệt.</b>',
                    'url' => Yii::$app->setting->get('siteurl_seller') . '/seller/index',
                    'status' => 0,
                    'created_at' => time()
                ]);
                Yii::$app->mongodb->getCollection('mail')->insert([
                    'title' => 'Tài khoản của bạn không đủ yêu cầu để chúng tôi duyệt',
                    'type' => 'seller',
                    'actor' => $id,
                    'layout' => 'seller_noactive',
                    'created_at' => time()
                ]);
                if(!empty(Yii::$app->request->post('User')['reason'])){
                    foreach ($model->reason as $value) {
                        $reason[] = $this->reason()[$value];
                    }
                    $data['reason'] = $reason;
                }else{
                    \Yii::$app->getSession()->setFlash('danger', 'Chưa chọn lý do không duyệt');
                    return $this->redirect(['view', 'id' => $id]);
                }
            }

            Yii::$app->mongodb->getCollection('product')->update(['owner.id' => $model->id], ['$set' => [
                    'owner.status' => (int) $model->status
            ]]);
            \Yii::$app->getSession()->setFlash('success', 'Cập nhật thành công');
            Yii::$app->mongodb->getCollection('user')->update(['_id' => $model->id], ['$set' => $data]);
            return $this->redirect(['view', 'id' => $id]);
        }
        $this->view->title = 'Thông tin của ' . $model->garden_name;
        return $this->render('view', ['model' => $model, 'reason' => $this->reason()]);
    }

    public function reason() {
        return [
            1 => 'Tên nhà vườn không chính xác',
            2 => 'Số điện thoại không chính xác',
            3 => 'Địa chỉ không chính xác'
        ];
    }

    public function actionCertificate() {
        $id = Yii::$app->request->post('id');
        $idUser = Yii::$app->request->post('idUser');
        $value = Yii::$app->request->post('value');
        $user = User::findOne($idUser);
        if (!empty($user)) {
            Yii::$app->mongodb->getCollection('user')->update(['_id' => $idUser, 'certificate.id' => $id], ['$set' => [
                    'certificate.$.active' => $value,
            ]]);
        }
        return TRUE;
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
