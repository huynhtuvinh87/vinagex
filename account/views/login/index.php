<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = \Yii::t('common', 'Đăng nhập');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">

            <div class="panel panel-default panel-login">
                <div class="panel-body form-signup">
                    <div class="logo text-center" style="margin-bottom:20px">
                        <a href="<?= Yii::$app->setting->get('siteurl') ?>"><img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png" width="300"></a>
                    </div>
                    <?= Alert::widget() ?>
                    <?= $form->field($model, 'emailorphone')->textInput() ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= Html::a(\Yii::t('common', 'Đăng ký tài khoản'), ['/register']) ?>

                    <?= Html::a(\Yii::t('common', 'Quên mật khẩu?'), ['forgetpassword'], ['class' => 'pull-right']) ?>


                    <div class="login-social">
                        <div class="form-group">
                            <?= Html::submitButton(\Yii::t('common', 'Đăng nhập'), ['class' => 'btn btn-signup', 'name' => 'signup-button']) ?>
<!--                            <p>Hoặc kết nối với tài khoản mạng xã hội</p>
                            <button class="btn-facebook"><i class="fa fa-facebook"></i> Facebook</button>
                            <button class="btn-google-plus"><i class="fa fa-google-plus"></i> Google</button>-->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>