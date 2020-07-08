<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('app', 'Lost your password');
?>

<section class="login_content row">
    <p>Please fill out your email. A link to reset password will be sent there.</p>
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= Html::submitButton('Send', ['class' => 'btn btn-primary pull-right']) ?>

    <?php ActiveForm::end(); ?>
</section>
<div class="lostpassword">
    <?= Html::a(Yii::t('app', 'Login'), ['login']) ?>
</div>