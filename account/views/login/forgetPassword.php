<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = 'Quên mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">

            <div class="panel panel-default" style="margin-top:40%">
                <div class="panel-body form-signup">
                    <div class="logo text-center" style="margin-bottom:20px">
                        <a href="<?= Yii::$app->setting->get('siteurl') ?>"><img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png" width="200"></a>
                    </div>
                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                    <?= Alert::widget() ?>
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Lấy lại mật khẩu', ['class' => 'btn btn-signup']) ?>
                        <p><a href="/login">Quay lại</a></p>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
