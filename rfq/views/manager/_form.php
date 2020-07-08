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
    <?= Yii::t('rfq', 'Hãy cho nhà cung cấp biết, bạn cần gì?') ?>
</p>
<p>
    <?= Yii::t('rfq', 'Thông tin cụ thể hơn chính xác hơn, sẽ giúp bạn tìm được nhà cung cấp tốt nhất.') ?>
</p>


<?= $form->field($model, 'title')->textInput(['placeholder' => Yii::t('rfq', 'Nhập tên sản phẩm cần cung cấp'), "maxlength" => 50]) ?>


<?php
foreach ($model->category() as $value) {
    if (!empty($value['parent'])) {
        $product_type[$value['id']] = $value['parent'];
        $category[$value['id']] = Yii::t('data', $value['title']);
    }
}
$array = [];
if (!empty($model->category_id)) {
    foreach ($product_type[$model->category_id] as $v) {
        $array[$v['id']] = Yii::t('data', $v['title']);
    }
}
?>
<?=
$form->field($model, 'category_id', [
    'template' => '{label}<div class="col-sm-3 col-xs-6">{input}{error}{hint}</div><div class="col-sm-3 col-xs-6">' . Html::dropDownList('RfqForm[product_type]', $model->product_type, $array, ['id' => 'rfqform-product_type', 'class' => 'form-control select2-select', 'style' => "border-radius: 0"]) . '</div>',
])->dropDownList($category, ['class' => 'form-control classic', 'prompt' => Yii::t('rfq', 'Chọn danh mục sản phẩm')])
?>
<?=
$form->field($model, 'quantity', [
    'template' => '{label}<div class="col-sm-3 col-xs-6">{input}{error}{hint}</div><div class="col-sm-3 col-xs-6">' . Html::dropDownList('RfqForm[unit]', $model->unit, ['tấn' => Yii::t('rfq', 'tấn'), 'kg' => Yii::t('rfq', 'Kg'), 'container' => Yii::t('rfq', 'Container'), 'quả' => Yii::t('rfq', 'Quả'), 'trái' => Yii::t('rfq', 'Trái'), 'thùng' => Yii::t('rfq', 'Thùng')], ['id' => 'unit', 'class' => 'form-control classic', 'style' => "border-radius: 0"]) . '</div>',
])->textInput(['class' => 'form-control classic', 'placeholder' => Yii::t('rfq', 'Nhập số lượng cần mua'), 'type' => 'number'])
?>
<?=
$form->field($model, 'content')->textarea(["maxlength" => 500, 'style' => ['height' => '150px','placeholder'=> Yii::t('rfq', 'Hãy cho nhà cung cấp biết  yêu cầu về sản phẩm của bạn: ví dụ như: kích  thước sản phẩm, chất lượng, hình thức đóng gói và thanh toán,....')]])
?>

<div class="form-group rfq-upload">
    <label class="control-label col-sm-3"><?= $model->getAttributeLabel('images') ?></label>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label for="upload-image" class="btn btn-default">
                    <?= Yii::t('rfq', 'Tải hình ảnh sản phẩm') ?>
                    <input type="file" id="upload-image" multiple style="display: none">
                </label>
            </div>
            <div class="panel-body">
                <div class="row form-group">
                    <label class="col-sm-12">
                        <small class="msg_img"><?= Yii::t('rfq', 'Tài lên ảnh mẫu, tối đa 3 hình ảnh (kích thước ảnh tối thiểu 450x450)') ?></small>
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
                                        <p class="text-center"><a href='javascript:void(0)' class='btn btn-danger btn_delete'><?= Yii::t('rfq', 'Xoá') ?></a></p>
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
<?= $form->field($model, 'date_start')->textInput(['placeholder' => Yii::t('rfq', 'Nhập thời gian bắt đầu mua')]) ?>
<?= $form->field($model, 'date_end')->textInput(['placeholder' => Yii::t('rfq', 'Nhập thời gian ngưng mua')]) ?>
<div class="form-group">
    <div class="col-sm-3 col-sm-offset-3">
        <?php
        if ($model->id) {
            echo Html::submitButton(Yii::t('rfq', 'Cập nhật'), ['class' => 'btn btn-success']);
        } else {
            echo Html::submitButton(Yii::t('rfq', 'Thêm mới'), ['class' => 'btn btn-primary']);
        }
        ?>  
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
if (!empty($model->category_id)) {
    echo $this->registerJs("
    $(document).ready(function () {
        $('#rfqform-product_type').show();
        $('.field-rfqform-category_id .select2').show();
               });
    ");
} else {
    echo $this->registerJs("
    $(document).ready(function () {
        $('#rfqform-product_type').hide();
        $('.field-rfqform-category_id .select2').hide();
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
        $('.field-rfqform-category_id .select2').show();
    });


    $('.select2-select').select2({})

    function upload(input, preview) {

        if (input.files) {
            var filesAmount = parseInt(input.files.length);
            for (i = 0; i < filesAmount; i++) {
                if (i < 5) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        var img = '<img class="img-thumbnail" src="' + event.target.result + '">';
                        $(preview).append('<div class="col-sm-3 col-xs-6 img-item"><div class=\"img_view\"><input type="hidden" name="image_temp[]" value="' + event.target.result + '">' + img + '</div><p class="text-center"><a href="javascript:void(0)" class="btn_delete btn btn-danger"><?= Yii::t('rfq', 'Xóa') ?></a></p></div>');

                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }

        }

    }
    $('#upload-image').on('change', function () {
        upload(this, 'div#result');
    });
    $('#rfqform-quantity').on('blur', function () {
        var val = parseInt($(this).val());
        if (isNaN(val)) {
            $(this).val('');
        } else {
            $(this).val(val);
        }
    });
    $('#rfqform-price').on('blur', function () {
        var val = parseInt($(this).val());
        if (isNaN(val)) {
            $(this).val('');
        } else {
            $(this).val(val);
        }
    });
    $(document).on('click', '.btn_delete', function (event) {
        $(this).parent().parent().remove();
    });
    $.datetimepicker.setLocale('vi');

    jQuery(function () {
        jQuery('#rfqform-date_start').datetimepicker({
            format: 'd/m/Y',
            onShow: function (ct) {
                this.setOptions({
                    maxDate: jQuery('#rfqform-date_end').val() ? jQuery('#rfqform-date_end').val() : false,
                    formatDate: 'd/m/Y'
                })
            },
            timepicker: false
        });
        jQuery('#rfqform-date_end').datetimepicker({
            format: 'd/m/Y',
            onShow: function (ct) {
                this.setOptions({
                    minDate: jQuery('#rfqform-date_start').val() ? jQuery('#rfqform-date_start').val() : false,
                    formatDate: 'd/m/Y'
                })
            },
            timepicker: false
        });
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>



