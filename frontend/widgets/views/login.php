<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal fade login-register-form" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-close"></i>
                </button>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#login-form"> Đăng nhập</a></li>
                    <li><a data-toggle="tab" href="#registration-form"> Đăng ký</a></li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div id="login-form" class="tab-pane fade in active">
                        <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => Yii::$app->setting->get('siteurl_id') . '/login']); ?>
                        <?= $form->field($login, 'url')->hiddenInput(['value' => "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']])->label(FALSE) ?>
                        <?= $form->field($login, 'emailorphone')->textInput() ?>
                        <?= $form->field($login, 'password')->passwordInput() ?>
                        <?= Html::submitButton('Đăng nhập', ['class' => 'btn btn-login-register', 'name' => 'login-button']) ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div id="registration-form" class="tab-pane fade">
                        <?php $form = ActiveForm::begin(['id' => 'singnup-form', 'action' => Yii::$app->setting->get('siteurl_id') . '/register']); ?>
                        <?= $form->field($signup, 'url')->hiddenInput(['value' => "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']])->label(FALSE) ?>
                        <?= $form->field($signup, 'login')->hiddenInput()->label(FALSE) ?>
                        <?= $form->field($signup, 'fullname')->textInput() ?>
                        <?= $form->field($signup, 'phone')->textInput() ?>
                        <?= $form->field($signup, 'email') ?>
                        <?= $form->field($signup, 'password')->passwordInput() ?>
                        <p class="policy">Tôi đồng ý với <a href="#">Chính sách bảo mật Vinagex</a></p>
                        <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-login-register', 'name' => 'signup-button']) ?>
                        <?php ActiveForm::end(); ?>
                    </div>

                </div>
            </div>
            <!--                                    <div class="modal-footer">-->
            <!--                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
            <!--                                    </div>-->
        </div>
    </div>
</div>