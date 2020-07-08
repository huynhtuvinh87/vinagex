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
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-signup">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="row">
            <div class="col-lg-6">




                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'gender')->dropDownList(['Nam' => 'Nam', 'Nữ' => 'Nữ'], ['class' => 'form-control select2-select']) ?>



            </div>
            <div class="col-lg-6">
                <div class="login-social">
                    <div class="form-group">
                        <?= $form->field($model, 'fullname')->textInput() ?>
                        <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-signup', 'name' => 'signup-button']) ?>
                        <p class="policy">Tôi đồng ý với <a href="#">Chính sách bảo mật Giataivuon</a></p>
                        <p>Hoặc kết nối với tài khoản mạng xã hội</p>
                        <button class="btn-facebook"><i class="fa fa-facebook"></i> Facebook</button>
                        <button class="btn-google-plus"><i class="fa fa-google-plus"></i> Google</button>
                    </div>

                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
