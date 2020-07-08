<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Đăng ký';
?>

<?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>
<h1>ĐĂNG KÝ</h1>
<?= $form->field($model, 'username')->textInput(['placeholder' => 'Tên đăng nhập'])->label(false) ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Nhập mật khẩu'])->label(false) ?>
<?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>
<?= $form->field($model, 'firstname')->textInput(['placeholder' => 'Họ'])->label(false) ?>
<?= $form->field($model, 'lastname')->textInput(['placeholder' => 'Tên'])->label(false) ?>
<div class="form-group">
    <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>
<div class="clearfix"></div>
<div class="separator">
    <div>
        <h1><i class="fa fa-paw" style="font-size: 26px;"></i> GII CMS!</h1>

        <p>©2016 GII CMS</p>
    </div>
</div>
<?php ActiveForm::end(); ?>