<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="auth-item-form">
    <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

    <div class="x_panel">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'fullname') ?>
                
                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= Html::submitButton('Lưu', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>
