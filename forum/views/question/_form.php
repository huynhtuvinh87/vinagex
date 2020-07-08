<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;

$product_type = [];
$category = [];
?>
<?php $form = ActiveForm::begin(['id' => 'question-form']); ?>  
<?= $form->field($model, 'title')->textInput() ?>

<div class="row">
    <div class="col-sm-3">
        <?php
        foreach ($model->category() as $value) {
            if (!empty($value['parent'])) {
                $product_type[$value['id']] = $value['parent'];
                $category[$value['id']] = $value['title'];
            }
        }
        ?>
        <?= $form->field($model, 'category_id')->dropDownList($category, ['class' => 'form-control select2-select', 'prompt' => 'Chọn danh mục', 'style' => 'width:135px',])->label(FALSE) ?>
    </div>
    <div class="col-sm-6">
        <div class="product_type" style="float: left; margin-right:  15px">
            <?php
            $array = [];
            if (!empty($model->category['id'])) {
                foreach ($product_type[$model->category['id']] as $v) {
                    $array[$v['id']] = $v['title'];
                }
            }
            ?>
            <?= $form->field($model, 'product_type')->dropDownList($array, ['class' => 'form-control select2-select'])->label(FALSE) ?>
        </div>
    </div>
</div>
<?=
$form->field($model, 'content')->textarea()
?>
<div class="form-group" style="overflow: hidden">
    <?php
    if ($model->id) {
        echo Html::submitButton('Sửa', ['class' => 'btn btn-success pull-right']);
    } else {
        echo Html::submitButton('Đăng', ['class' => 'btn btn-primary pull-right']);
    }
    ?>  
</div>
<?php ActiveForm::end(); ?>
<?php
if (!empty($model->category['id'])) {
    echo $this->registerJs("
    $(document).ready(function () {
        $('.product_type').show()
               });
    ");
} else {
    echo $this->registerJs("
    $(document).ready(function () {
        $('.product_type').hide();
               });
    ");
}
?>


<?php ob_start(); ?>
<script>
    $("body").on("click", ".close_modal_upload", function(event) {
        $(".modal-upload").modal('hide');
    });
    function getProductType(id) {
        var product_type = <?php echo json_encode($product_type) ?>;
        var product_type_id = <?php echo json_encode($model->product_type) ?>;
        var option = '';
        for (var key in product_type) {
            if (key == id) {
                for (var i = 0; i < product_type[key].length; i++) {
                    if (product_type[key][i].id == product_type_id) {
                        option += '<option selected value=' + product_type[key][i].id + '>' + product_type[key][i].title + '</option>';
                    } else {
                        option += '<option  value=' + product_type[key][i].id + '>' + product_type[key][i].title + '</option>';
                    }

                }

            }
        }
        return option;
    }

    $("#questionform-content").summernote({
        height: 300,
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
  
    $("body").on("change", "#questionform-category_id", function(event) {
       var id = $(this).val();
       $("#questionform-product_type").html(getProductType(id));
       $(".product_type").show();
    });

    <?php if ($model->product_type) { ?>
        $(document).ready(function(){
           var id = $("#questionform-category_id").val();
           $("#questionform-product_type").html(getProductType(id));
           $(".product_type").show();
        });
    <?php } ?>

    $(document).ready(function(){
        $('.select2-select').select2({})
        
    });


</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>



