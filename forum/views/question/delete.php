<?php 
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
 ?>

<div class="row">
		<div class="col-md-12">
			<?php $form = ActiveForm::begin(['id' => 'delete-form']); ?>  
			<div class="form-group">				
				<span>Bạn có chắc muốn xóa??</span>
		           <?= Html::submitButton('Đồng ý' , ['class' => 'btn btn-success pull-right']); ?>
		    <?php ActiveForm::end(); ?>
		</div>
</div>

<?php ob_start(); ?>
<script>

    $(document).on('submit', '#delete-form', function (event){
        event.preventDefault();
    $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/delete", 'id' => $id]);  ?>',
            type: 'post',
            data: $('form#delete-form').serialize(),
            success: function(data) {
					window.location.href = window.location.hostname; 
            	}
            });
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>