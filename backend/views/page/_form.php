<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="col-md-9 col-sm-9 col-xs-12">

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'url')->textInput() ?>
        <?= $form->field($model, 'content')->textarea() ?>

    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">

        <div class="x_title">
            Trạng thái
        </div>
        <div class="x_panel">
            <?= $form->field($model, 'status')->dropDownList(['Hiển thị','Không hiển thị'])->label(FALSE) ?>
        </div>
        <div class="x_title">
            Widget
        </div>
        <div class="x_panel">
            <?= $form->field($model, 'widget')->dropDownList($model->widget())->label(FALSE) ?>
        </div>

        <div class="x_title">
            Hình ảnh
        </div>
        <div class="x_panel">
            <label for="page-image">
                <?= $form->field($model, 'fileImg')->fileInput(['class' => 'upload-file-selector' ])->label(FALSE) ?>
            </label>
            <img id="rs-image" class="img-thumbnail" src="<?= ($model->fileImg) ? explode(',', $model->fileImg)[1] : "" ?>">
            <?= $form->field($model, 'fileImg')->textInput()->hiddenInput()->label(FALSE) ?>
        </div>
    
        <div class="form-group">
            <?= Html::submitButton(empty($model->id)?'Thêm mới':'Cập nhật' , ['class' => empty($model->id)?'btn btn-success pull-right':'btn btn-primary pull-right']); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
if ($model->image) {
    echo $this->registerJs("
$(document).ready(function () {
        $('#rs-image').show();
    });
");
} else {
    echo $this->registerJs("
$(document).ready(function () {
        $('#rs-image').hide();
    });
");
}
?>
<?=
$this->registerJs("
$(document).ready(function () {
        $(document).on('change', '.upload-file-selector', function () {
            $('#rs-image').show();
            readURL(this, '#rs-image');
        });
        function readURL(input, id_show) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(id_show).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    });
");
?>

<?php
ob_start();
?>
<script type="text/javascript">
    $("#pageform-content").summernote({
        height: 300,
    });

    $('.close_modal_upload').click(function(){
        $('.modal-upload').modal('hide');
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>