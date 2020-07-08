<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(['id' => 'form-image']) ?>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <?= $form->field($model, 'content')->textarea() ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
ob_start();
?>
<script type="text/javascript">
    $("#productimageform-content").summernote({
        toolbar: [
//            ['font', ['bold', 'italic', 'underline']],
//            ['fontsize', ['fontsize']],
//            ['color', ['color']],
//            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['picture', 'video']],
//            ['view', ['fullscreen']],
        ],
        height: 450,
        hint: {
            words: ['apple', 'orange', 'watermelon', 'lemon'],
            match: /\b(\w{1,})$/,
            search: function (keyword, callback) {
                callback($.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                }));
            }
        }
    });
    $('#productimageform-time').datepicker({
        dateFormat: 'dd/mm/yy',
        startDate: new Date(),
        autoclose: true,
        todayHighlight: true,
        changeMonth: true,
        changeYear: true
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>