<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Đăng câu hỏi';
?>
<div class="container">
    <h2>Thêm câu hỏi mới</h2>
    <div class="panel panel-default">
        <div class="panel-body">

            <?php $form = ActiveForm::begin(); ?>  
            <?= $form->field($model, 'title')->textInput() ?>
            <?= $form->field($model, 'category_id')->dropDownList($category, ['prompt' => 'Chọn danh mục']) ?>
            <?= $form->field($model, 'parent_id')->dropDownList([], ['prompt' => 'Chọn danh mục']) ?>
            <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
            <?= Html::submitButton('Xác nhận', ['class' => 'btn btn-success'])
            ?>  

            <?php ActiveForm::end(); ?>

        </div>
    </div>
    <?php if (Yii::$app->session->getFlash('success')) { ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('success'); ?>	        
        </div>
    <?php } ?>
</div>


<?= $this->registerJs("
	$(document).ready(function(){
   		$('#questionform-category_id').change(function(){
   			$('#questionform-parent_id').empty(); 
   			$('#questionform-parent_id').append('<option>Chọn danh mục</option>');
   			var category = $(this).val();
   			var base_url = '/ajax/parent';
   			$.ajax({
   				type:'POST',
   				url: base_url,
   				data: 'category_id='+category,
   				success: function(data){
   					$.each(data, function( index, value ) {
   						$('#questionform-parent_id').append('<option value='+index+'>'+value+'</option>');
					});	 
   				}
   			});
   		});
});
"); ?>