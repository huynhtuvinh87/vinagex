<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đặt lại mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-signup">
        <p style="margin-bottom: 30px">Vui lòng chọn mật khẩu mới của bạn::</p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Lưu', ['class' => 'btn btn-signup']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>