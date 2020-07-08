<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = 'Quên mật khẩu';
?>
<div class="site-login" style="margin: 10% auto">
    <?= Alert::widget() ?>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <p style="margin-bottom: 30px">Nhập địa chỉ email của bạn dưới đây và chúng tôi sẽ gửi lại mật khẩu cho bạn.</p>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form', 'layout' => 'horizontal']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <div class="col-lg-6 col-lg-offset-3">
                    <?= Html::submitButton('Gửi', ['class' => 'btn btn-primary']) ?>
                    <p><a href="/user/login">Quay lại</a></p>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>