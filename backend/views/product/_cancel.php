<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php $form = ActiveForm::begin(['id' => 'cancel-form','enableAjaxValidation' => true]) ?>
        
    
        <div style="overflow: hidden;">
                <div class="form-group">
                <label>Tên sản phẩm: <?= $model['title'] ?></label>
                </div>

                <?= $form->field($model, 'note_cancel[]')->checkboxList($model->getError()) ?>
        </div>
    <?php ActiveForm::end(); ?>


