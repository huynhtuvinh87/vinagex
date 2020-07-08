<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng ký';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default panel-register">
                <div class="panel-body form-signup">
                    <div class="logo text-center" style="margin-bottom:20px">
                        <a href="<?= Yii::$app->setting->get('siteurl') ?>"><img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png" width="300"></a>
                    </div>
                    <?= $form->field($model, 'fullname')->textInput() ?>
                    <?= $form->field($model, 'phone')->textInput() ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <div class="login-social">
                        <div class="form-group">

                            <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-signup', 'name' => 'signup-button']) ?>
                            <p class="policy">Tôi đồng ý với <a href="#">Chính sách bảo mật Vinagex</a></p>
                            <p>Bạn đã có tài khoản. Nhấn vào <a href="/login">đây để đăng nhập.</a></p>
    <!--                        <p>Hoặc kết nối với tài khoản mạng xã hội</p>
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

