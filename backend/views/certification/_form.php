<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
            'id' => 'certification-form',
            'method'=>'post', 
            'enableAjaxValidation' => true,
    ]) ?>
    
    <div class="col-md-8 col-md-offset-2 col-sm-9 col-xs-12">

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= Html::submitButton(empty($model->id)?'Thêm mới':'Cập nhật' , ['class' => empty($model->id)?'btn btn-success pull-right':'btn btn-primary pull-right']); ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php ob_start(); ?>
   <script>
       $(document).on('submit', '#certification-form', function (event) {
        $.ajax({
            url: '<?= empty($model->id)?Yii::$app->urlManager->createUrl(["certification/create"]):Yii::$app->urlManager->createUrl(["certification/update/".$model->id]); ?>',
            type: 'post',
            data: $('form#certification-form').serialize(),
            success: function (data) {

            }
        });
    });
   </script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
 