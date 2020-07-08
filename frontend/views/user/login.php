<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng nhập';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-signup login">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <div class="row">
            <div class="col-lg-6">


                <?= $form->field($model, 'email')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
    
                    <?= Html::a('Đăng ký tài khoản', ['signup']) ?>
       
                    <?= Html::a('Quên mật khẩu', ['forgetpassword'],['class'=>'pull-right']) ?>
            
            </div>
            <div class="col-lg-6">
                <div class="login-social">
                    <div class="form-group">
                        <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-signup', 'name' => 'signup-button']) ?>
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
