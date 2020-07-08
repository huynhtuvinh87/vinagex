<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\Constant;

$this->title = 'Đăng ký bán hàng';
?>
<div class="site-signup" style="margin-top: 50px">
    <div class="row">
        <div class="col-sm-8 form-seller col-sm-offset-2 ">
            <h1 style="font-weight: 300; text-align: center; text-transform: uppercase; margin-bottom: 30px">Đăng ký bán hàng cùng Giá tại vườn</h1>
            <p style="text-align: center; margin-bottom: 50px">Cảm ơn đối tác đã tin tưởng và lựa chọn đồng hành cùng Giataivuon! <br>
                Vui lòng hoàn tất biểu mẫu và cung cấp đầy đủ hồ sơ theo hướng dẫn để có thể bán hàng nhanh nhất.</p>

            <div class="col-sm-offset-2">
                <?php $form = ActiveForm::begin(['id' => 'form-signup', 'layout' => 'horizontal']); ?>
                <h4>Thông tin đăng nhập</h4>
                <?= $form->field($model, 'email')->textInput(['disabled'=>TRUE]) ?>
                <?= $form->field($model, 'phone')->textInput(['disabled'=>TRUE]) ?>
                <?= $form->field($model, 'auth_key')->hiddenInput()->label(FALSE) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_rep')->passwordInput() ?>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3">
                        <?= Html::submitButton('Gửi', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
