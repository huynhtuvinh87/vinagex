<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['id' => 'delete-form']); ?>  
        <div class="form-group">				
            <span>Bạn có chắc muốn xóa???!</span>
            <?= Html::submitButton('Đồng ý', ['class' => 'btn btn-success pull-right', 'id' => 'btn-delete', 'name' => 'submit']); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?= $this->registerJs("$(document).on('submit', '#delete-form', function (event){
        event.preventDefault();
    $.ajax({
            url: '" . Yii::$app->urlManager->createUrl(["question/delanswer", 'id' => $id]) . "',
            type: 'post',
            data: $('form#delete-form').serialize(),
            success: function(data) {
            	$('#parent-'+data).remove();
                $('#modal-delete').modal('hide');
            }
        });
});") ?>