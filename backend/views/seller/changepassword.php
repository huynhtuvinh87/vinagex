<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Account */

$this->title                   = \Yii::t('app', 'Change the password');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Personal information'), 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-create">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">
                    <?php $form                          = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>  
                    <?php
                    if (Yii::$app->session->hasFlash('success')) {
                        ?>
                        <div class="alert alert-success" role="alert">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php } ?>
                    <?= $form->field($model, 'password', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('password') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->passwordInput() ?>
                    <?= $form->field($model, 'password_new', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('password_new') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->passwordInput() ?>
                    <?= $form->field($model, 'password_repeat', ['template' => '<label class="col-md-2 col-sm-4 col-xs-12 control-label">' . $model->getAttributeLabel('password_repeat') . '</label><div class="col-md-6 col-sm-9 col-xs-12">{input}{hint}{error}</div>'])->passwordInput() ?>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4">
                            <?= Html::submitButton($this->title, ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>