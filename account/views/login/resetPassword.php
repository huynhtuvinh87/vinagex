<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;
$this->title = 'Đặt lại mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="signup">
    <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">

            <div class="panel panel-default panel-login">
                <div class="panel-body form-signup">
                    <div class="logo text-center" style="margin-bottom:20px">
                        <a href="<?= Yii::$app->setting->get('siteurl') ?>"><img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png" width="200"></a>
                    </div>
                    <?= Alert::widget() ?>

                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Lưu', ['class' => 'btn btn-signup']) ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>