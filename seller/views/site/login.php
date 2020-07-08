<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;
$this->title = 'Đăng nhập';
?>
<div class="site-login" style="margin: 10% auto">
    <?= Alert::widget() ?>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'horizontal']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <div class="form-group">
                <div class="col-lg-6 col-lg-offset-3">
                     <?= Html::a('Quên mật khẩu', ['site/request-password-reset']) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-6 col-lg-offset-3">
                    <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
