<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form row">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <div class="x_title">
            Thông tin khách hàng
        </div>
        <div class="x_panel">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'fullname')->textInput()->label() ?>
                    <?= $form->field($model, 'email')->textInput()->label() ?> 
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'phone')->textInput()->label() ?>
                    <?= $form->field($model, 'address')->textarea()->label() ?>
                </div>
            </div>
            <?= $form->field($model, 'note')->textarea()->label() ?>

        </div>
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">

        <div class="x_title">
            <?= \Yii::t('app', 'Status') ?>
        </div>
        <div class="x_panel">
            <?= $form->field($model, 'status')->dropDownList($model->publish)->label(FALSE) ?>
        </div>
        <div class="x_title">
            <?= \Yii::t('app', 'Total') ?>
        </div>
        <div class="x_panel">
            <?= $model->total ? number_format($model->total, 0, '', '.') : 0 ?>₫ 
        </div>
        <div class="form-group">
            <?= Html::submitButton(($model->isNewRecord) ? \Yii::t('app', 'Create') : \Yii::t('app', 'Update'), ['class' => ($model->isNewRecord) ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

