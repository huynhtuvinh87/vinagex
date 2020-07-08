<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(['id'=>'create_form','enableAjaxValidation' => true]) ?>
    <div class="row">
    	<div class="col-xs-12 col-sm-12">
        <?= $form->field($model, 'name_bank')->textInput() ?>

        <?= $form->field($model, 'account_name')->textInput() ?>

        <?= $form->field($model, 'account_number')->textInput() ?>

        <?= $form->field($model, 'branch_bank')->textInput() ?>

        <?= Html::submitButton(empty($model->bank_id)?'Thêm mới':'Cập nhật' , ['class' => empty($model->bank_id)?'btn btn-success pull-right':'btn btn-primary pull-right']); ?>
        </div>
     </div>
    <?php ActiveForm::end(); ?>
   

