<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" style="margin: 10% auto">
    <?= Alert::widget() ?>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">

            <p>Vui lòng chọn mật khẩu mới của bạn:</p>

            <div class="row">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form', 'layout' => 'horizontal']); ?>


                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>


                <div class="form-group">
                    <div class="col-lg-6 col-lg-offset-3">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
</div>
