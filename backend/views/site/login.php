<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('app', 'Login');
?>
<section class="login_content row">
    <?php
    $form = ActiveForm::begin();
    ?>  
    <?= $form->field($model, 'username')->textInput()->label() ?>
    <?= $form->field($model, 'password')->passwordInput()->label() ?>
    <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary pull-right', 'name' => 'login-button']) ?>

    <?php ActiveForm::end(); ?>
</section>
<div class="lostpassword">
    <?= Html::a('Quên mật khẩu', ['forgot']) ?>
</div>