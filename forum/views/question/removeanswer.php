<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="row">
    <div class="col-md-12">
<?php $form = ActiveForm::begin(['id' => 'delete-form']); ?>  
        <div class="form-group">				
            <span>Bạn có chắc muốn xóa??</span>
            <?= Html::submitButton('Đồng ý', ['class' => 'btn btn-success pull-right', 'id' => 'btn-delete', 'name' => 'submit']); ?>
<?php ActiveForm::end(); ?>
        </div>
    </div>

<?php ob_start(); ?>
<script>

    $(document).on('submit', '#delete-form', function (event){
        var count = parseInt($('.count-answer').attr('data-count') - 1);
        event.preventDefault();
    $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/removeanswer", 'id' => $id]);  ?>',
            type: 'post',
            data: $('form#delete-form').serialize(),
            success: function(data) {
                    if(count == 0){
                        $('.count-answer').attr('data-count', 0);
                        $('.count-answer').html('<h5 class="empty">Chưa có câu trả lời nào</h5>');
                    }else if(count > 0){
                        $('.count-answer').html('<span>'+count+'</span> trả lời');
                        $('.count-answer').attr('data-count',count);
                    }
                $('#id-'+data).remove();
                $('#modal-delete').modal('hide'); 
            }
            });
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>