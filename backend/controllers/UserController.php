<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use common\models\User;
use backend\models\SignupForm;
use backend\models\Profile;
use backend\models\PasswordForm;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class UserController extends Controller {

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

        $query = User::find()->where(['role' => User::ROLE_ADMIN])->andWhere(['<>', 'role', User::ROLE_SUPERADMIN]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $user = $this->findModel($id);
        if (\Yii::$app->user->identity->role != User::ROLE_SUPERADMIN) {
            throw new NotFoundHttpException('Bạn không có quyền này.');
        }
        $model = new Profile(['_id' => $id]);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->profile()) {
                return $this->redirect(['index']);
            }
        }
        $user = User::findOne($id);

        return $this->render('update', [
                    'model' => $model
        ]);
    }

    public function actionDelete($id) {
        if (\Yii::$app->user->identity->role != User::ROLE_SUPERADMIN) {
            throw new NotFoundHttpException('Bạn không có quyền này.');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionProfile() {
        $model = new Profile(['id' => \Yii::$app->user->id]);
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->profile()) {
                Yii::$app->getSession()->setFlash('success', 'Bạn đã cập nhật thành công!');
                return $this->redirect(['profile']);
            }
        }
        $user = $this->findModel(\Yii::$app->user->id);
        return $this->render('profile', [
                    'model' => $model
        ]);
    }

    public function actionChangepassword() {
        $model = new PasswordForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->change()) {
                Yii::$app->getSession()->setFlash('success', 'Bạn đã thay đổi mật khẩu thành công!');
                return $this->redirect(['changepassword']);
            }
        }
        $user = $this->findModel(\Yii::$app->user->id);
        return $this->render('changepassword', [
                    'model' => $model,
                    'user' => $user
        ]);
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
