<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$product_type = [];
$category = [];
?>
<?php
$form = ActiveForm::begin([
            'id' => 'rfq-form',
            'layout' => 'horizontal',
        ]);
?>  
<p>
    Hãy cho nhà cung cấp biết bạn cần gì.
</p>
<p>
    Thông tin cụ thể hơn, chính xác hơn, chúng tôi sẽ giúp bạn nhà cung cấp tốt nhất.
</p>
<?= $form->field($model, 'title')->textInput(['placeholder' => "Nhập tên sản phẩm"]) ?>

<?php
foreach ($model->category() as $value) {
    if (!empty($value['parent'])) {
        $product_type[$value['id']] = $value['parent'];
        $category[$value['id']] = $value['title'];
    }
}
$array = [];
if (!empty($model->category['id'])) {
    foreach ($product_type[$model->category['id']] as $v) {
        $array[$v['id']] = $v['title'];
    }
}
?>
<?=
$form->field($model, 'category_id', [
    'template' => '{label}<div class="col-sm-3 col-xs-6">{input}{error}{hint}</div><div class="col-sm-3 col-xs-6">' . Html::dropDownList('RfqForm[product_type]', $model->product_type, $array, ['id' => 'rfqform-product_type', 'class' => 'form-control select2-select', 'style' => "border-radius: 0"]) . '</div>',
])->dropDownList($category, ['class' => 'form-control classic', 'prompt' => 'Chọn danh mục'])
?>
<?=
$form->field($model, 'quantity', [
    'template' => '{label}<div class="col-sm-3 col-xs-6">{input}{error}{hint}</div><div class="col-sm-2 col-xs-6">' . Html::dropDownList('RfqForm[unit]', $model->unit, ['tấn' => 'Tấn', 'kg' => 'Kg'], ['id' => 'unit', 'class' => 'form-control classic', 'style' => "border-radius: 0"]) . '</div>',
])->textInput($array, ['class' => 'form-control classic', 'type' => 'number'])
?>
<?= $form->field($model, 'price')->textInput(['placeholder' => "Giá sản phẩm", 'class' => 'form-control', 'type' => 'number']) ?>
<?=
$form->field($model, 'content')->textarea()
?>

<div class="form-group">
    <label class="control-label col-sm-3"><?= $model->getAttributeLabel('images') ?></label>
    <div class="col-sm-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label for="upload-image">
                    <input type="file" id="upload-image" multiple>
                </label>
            </div>
            <div class="panel-body">
                <div class="row form-group">
                    <label class="col-sm-12">
                        <small class="msg_img"><?= Yii::t('rfq', 'rfq_upload_validate_text') ?></small>
                    </label>
                    <div class="col-sm-12">

                        <div id="result" class="row" style="margin-top:20px;">
                            <?php
                            if ($model->images) {
                                foreach ($model->images as $key => $value) {
                                    ?>
                                    <div class="col-sm-3 col-xs-6 img-item">
                                        <div class='img_view'>
                                            <input type="hidden" name="image_temp[]" value="<?= $value ?>">
                                            <img  class='img-thumbnail' src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=350x300">
                                        </div>
                                        <a href='javascript:void(0)' class='btn btn-danger btn_delete'>Xoá</a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?=
                $form->field($model, 'image_error', [
                    'template' => '{error}',
                ])->textInput(['type' => 'hidden'])
                ?>
            </div>
        </div>
    </div>
</div>
<?= $form->field($model, 'date_start')->textInput() ?>
<?= $form->field($model, 'date_end')->textInput() ?>
<div class="form-group">
    <div class="col-sm-3 col-sm-offset-3">
        <?php
        if ($model->id) {
            echo Html::submitButton('Chỉnh sửa yêu cầu', ['class' => 'btn btn-success']);
        } else {
            echo Html::submitButton('Tạo mới yêu cầu', ['class' => 'btn btn-primary']);
        }
        ?>  
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
if (!empty($model->category['id'])) {
    echo $this->registerJs("
    $(document).ready(function () {
        $('#rfqform-product_type').show()
               });
    ");
} else {
    echo $this->registerJs("
    $(document).ready(function () {
        $('#rfqform-product_type').hide();
               });
    ");
}
?>


<?php ob_start(); ?>
<script>
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

    $("body").on("change", "#rfqform-category_id", function (event) {
        var id = $(this).val();
        $("#rfqform-product_type").html(getProductType(id));
        $("#rfqform-product_type").show();
    });

<?php if ($model->category_id) { ?>
        $(document).ready(function () {
            var id = $("#rfqform-category_id").val();
            $("#rfqform-product_type").html(getProductType(id));
            $("#rfqform-product_type").show();
        });
<?php } ?>


    $('.select2-select').select2({})

    function upload(input, preview) {
        console.log(input);
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    var img = '<img class="img-thumbnail" src="' + event.target.result + '">';
                    $(preview).append('<div class="col-sm-3 col-xs-6 img-item"><div class=\"img_view\"><input type="hidden" name="image_temp[]" value="' + event.target.result + '">' + img + '</div><p class="text-center"><a href="javascript:void(0)" class="btn_delete btn btn-danger">Xoá</a></p></div>');

                }
                reader.readAsDataURL(input.files[i]);
            }

        }

    }
    ;
    $('#upload-image').on('change', function () {
        upload(this, 'div#result');
    });

    $.datetimepicker.setLocale('vi');
    jQuery(function () {
        jQuery('#rfqform-date_start').datetimepicker({
            validateOnBlur: true,
            format: 'd/m/Y',
            onShow: function (ct) {
                if (jQuery('#rfqform-date_end').val()) {
                    var result = jQuery('#rfqform-date_end').val().split('/');
                    this.setOptions({
                        maxDate: result[2] + '/' + result[1] + '/' + result[0]
                    })
                } else {
                    this.setOptions({
                        maxDate: false
                    })
                }
            },
            yearStart: (new Date()).getFullYear(),
            yearEnd: parseInt((new Date()).getFullYear()) + 2,
            timepicker: false
        });
        jQuery('#rfqform-date_end').datetimepicker({
            validateOnBlur: true,
            format: 'd/m/Y',
            onShow: function (ct) {
                var result = jQuery('#rfqform-date_start').val().split('/');
                $start = result[2] + '/' + result[1] + '/' + result[0];
                this.setOptions({
                    minDate: $start ? $start : false
                })
            },
            yearStart: (new Date()).getFullYear(),
            yearEnd: parseInt((new Date()).getFullYear()) + 2,
            timepicker: false
        });
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>



