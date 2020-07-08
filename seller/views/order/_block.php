<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php $form = ActiveForm::begin(['id' => 'order-form','enableAjaxValidation' => true]) ?>
        <div style="overflow: hidden;">
             <?= $form->field($model, 'reason[]')->checkboxList($model->block()) ?>
             <?= $form->field($model, 'description')->textInput() ?>
        </div>
    <?php ActiveForm::end(); ?>

<?php ob_start(); ?>
<script type="text/javascript">
    $('.field-orderform-description').hide();
    $('input[type=checkbox]').on('change', function() {
    	if($(this).val() == <?= $model::OTHER_BLOCK?>){
    		$('.field-orderform-description').toggle();
    	}
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

