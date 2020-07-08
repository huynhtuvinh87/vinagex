<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Quên mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-signup">
        <p style="margin-bottom: 30px">Nhập địa chỉ email của bạn dưới đây và chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu của bạn.</p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Gửi', ['class' => 'btn btn-signup']) ?>
                    <p><a href="/user/login">Quay lại</a></p>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
