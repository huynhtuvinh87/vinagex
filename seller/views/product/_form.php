<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use common\components\Constant;
use common\widgets\Alert;

$unit = [];
$os_unit = [];
$product_type = [];
$category = [];
$action = Yii::$app->controller->action->id;
?>
<?= Alert::widget() ?>
<?php
$form = ActiveForm::begin([
            'id' => 'product-form',
            'layout' => 'horizontal',
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-sm-3 col-xs-12',
                    'wrapper' => 'col-sm-9  col-xs-12',
                ],
            ],
        ]);
?>
<!-- profile-details -->

<?=
$form->field($model, 'title')
?>
<?php
foreach ($model->category() as $value) {
    if (!empty($value['parent'])) {
        $unit[$value['id']] = $value['unit'];
        $os_unit[$value['id']] = $value['oscillation_unit'];
        $product_type[$value['id']] = $value['parent'];
        $category[$value['id']] = $value['title'];
    }
}
?>
<?= $form->field($model, 'category_id')->dropDownList($category, ['class' => 'form-control select2-select', 'prompt' => 'Chọn danh mục']) ?>

<div class="product_type" style="width: 100%">
    <?php
    $array = [];
    $array_unit = [];
    $array_osunit = [];
    if (!empty($model->category_id)) {
        foreach ($product_type[$model->category_id] as $v) {
            $array[$v['id']] = $v['title'];
        }
        foreach ($unit[$model->category_id] as $u) {
            $array_unit[$u] = $u;
        }
        foreach ($os_unit[$model->category_id] as $o) {
            $array_osunit[$o] = $o;
        }
    }
    ?>

    <?=
    $form->field($model, 'product_type', [
        'template' => '<label class="control-label col-sm-3"></label><div class="col-sm-2 col-xs-6">{input}{error}{hint}</div><div class="col-sm-2 col-xs-5">' . Html::dropDownList('ProductForm[unit]', $model->unit, $array_unit, ['id' => 'unit', 'class' => 'form-control', 'style' => "width:120px; border-radius: 0", 'required' => TRUE]) . '</div>',
    ])->dropDownList($array, ['class' => 'form-control select2-select'])
    ?>
</div>
<?=
$form->field($model, 'content')->textarea(['style' => 'height:100px', 'placeholder' => 'Giới thiệu về sản phẩm, chủng loại, xuất xứ, thông tin dinh dưỡng, lưu ý bảo quản, hướng dẫn sử dụng...'])
?>

<?= $form->field($model, 'price_by_area')->inline()->radioList(Constant::PRICE_BY_AREA) ?>
<div class=" form-group">
    <div class="price_by_area price_area <?= count($model->province) == 0 ? 'error' : '' ?>"  style="<?= $model->price_by_area == 2 ? 'display: block' : 'display:none' ?>">
        <?= $form->field($model, 'province')->dropDownList($model->province(), ['class' => 'form-control select2-tag', 'style' => 'width:100%', 'multiple' => TRUE])->label(FALSE) ?>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-3">Giá sản phẩm</label>
    <div class="col-sm-9">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-price" role="tablist" style=" background-color: #f5f5f5; border:1px solid #ddd;">
            <li role="presentation" class="<?= $model->price_type == 1 ? "active" : "" ?>"><a href="#price1" aria-controls="price1" role="tab" data-toggle="tab" data-type="1">Mặc định</a></li>
            <li role="presentation" class="<?= $model->price_type == 2 ? "active" : "" ?>"><a href="#price2" aria-controls="price2" role="tab" data-toggle="tab" data-type="2">Theo khung giá</a></li>
            <li role="presentation" class="<?= $model->price_type == 3 ? "active" : "" ?>"><a href="#price3" aria-controls="price3" role="tab" data-toggle="tab" data-type="3">Theo phân loại hàng</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content" style="border:1px solid #ddd; border-top:0; margin-bottom: 15px; padding: 10px">
            <div role="tabpanel" class="tab-pane <?= $model->price_type == 1 ? "active" : "" ?>" id="price1">
                <?= $this->render('price/default', ['model' => $model, 'form' => $form]) ?>
            </div>
            <div role="tabpanel" class="tab-pane <?= $model->price_type == 2 ? "active" : "" ?>" id="price2">
                <?= $this->render('price/approx', ['model' => $model, 'form' => $form]) ?>
            </div>
            <div role="tabpanel" class="tab-pane <?= $model->price_type == 3 ? "active" : "" ?>" id="price3">
                <?= $this->render('price/classify', ['model' => $model, 'form' => $form]) ?>
            </div>
        </div>

    </div>
</div>
<?=
$form->field($model, 'price_type')->hiddenInput()->label(FALSE)
?>
<?=
$form->field($model, 'description')->textarea(['style' => 'height:100px', 'placeholder' => 'Nhập vào 1 số thông tin như: quy cách đóng gói, kích thướt sản phẩm, khối lượng sản phẩm...'])
?>

<div class="form-group">
    <label class="control-label col-sm-3"><?= $model->getAttributeLabel('images') ?></label>
    <div class="col-sm-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <label for="upload-image" class="btn btn-default">
                    Tải ảnh sản phẩm
                    <input type="file" id="upload-image" multiple style="display: none">
                </label>
            </div>
            <div class="panel-body">
                <div class="row form-group">
                    <label class="col-sm-12">
                        <small class="msg_img">Hình ành phải chất lượng, tối thiểu 3 hình (kích thước hình ảnh nhỏ nhất là 450x450)</small>
                    </label>
                    <div class="col-sm-12">

                        <div id="result" class="row" style="margin-top:20px;">
                            <?php
                            if ($model->_images) {
                                foreach ($model->_images as $key => $value) {
                                    ?>
                                    <div class="col-sm-3 col-xs-6 img-item">
                                        <div class='img_view'>
                                            <input type="hidden" name="image_temp[]" value="<?= $value ?>">
                                            <img  class='img-thumbnail' src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=350x300">
                                        </div>
                                        <p class="text-center"><a href='javascript:void(0)' class='btn btn-danger btn_delete'>Xoá</a></p>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?=
                $form->field($model, 'error_image', [
                    'template' => '<div class="col-sm-12 error">{error}</div>',
                ])->textInput(['type' => 'hidden'])
                ?>
            </div>
        </div>
    </div>
</div>
<?=
$form->field($model, 'time_to_sell')->radioList($model->time_to_sell())
?>

<div class="form-group time_to_sell" style="display:<?= ($model->time_to_sell == 2) ? 'block' : "none" ?>">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="row">
            <div class="col-sm-3">
                Ngày bắt đầu bán 
                <input type="text" id="productform-time_begin" name="ProductForm[time_begin]" value="<?= ($model->time_to_sell == 2) ? $model->time_begin : "" ?>" class="form-control">
            </div>
            <div class="col-sm-3">
                Ngày kết thúc bán 
                <input type="text" id="productform-time_end" name="ProductForm[time_end]" value="<?= ($model->time_to_sell == 2) ? $model->time_end : "" ?>" class="form-control">
            </div>
        </div>
    </div>												
</div>
<div class="form-group">
    <div class=" col-sm-offset-3 col-sm-3">
        <button type="button" id="submit-product-form"  class="btn btn-success" style="padding: 10px 40px"><?= $model->id ? "Cập nhật" : "Đăng sản phẩm" ?></button>
    </div>												
</div>

<?php ActiveForm::end(); ?>	

<?php
if (!empty($model->category_id)) {
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
<?= $this->registerJs('
$("body").on("change", "#productform-category_id", function(event) {
   var id = $(this).val();
   $("#unit").html(getUnit(id));
   $("#os_unit").html(getOsUnit(id));
   $("#productform-product_type").html(getProductType(id));
   $(".product_type").show();
});

') ?>
<?php
$time_begin = \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d");
$time_end = \Yii::$app->formatter->asDatetime(time() + 3600 * 24, "php:Y-m-d");
?>
<?php ob_start(); ?>
<script type="text/javascript">

    function upload(input, preview) {
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
    $('#upload-image').on('change', function () {
        upload(this, 'div#result');
    });
    $('.nav-tabs a').click(function (e) {
        e.preventDefault();
        var type = parseInt($(this).attr('data-type'));
        $("#oscillate").show();
        if (type == 3) {
            $("#oscillate").hide();
        }
        if (!$(this).hasClass("active")) {
            $("#productform-price_type").val(type);
        }
    });
    $('.select2-tag').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function (params) {
            return undefined;
        }
    });
    $('input:radio[name=\"ProductForm[price_by_area]\"]').change(function () {
        if ($('input[name=\"ProductForm[price_by_area]\"]:checked').val() == 1) {
            $('.price_area').hide();
        }
        if ($('input[name=\"ProductForm[price_by_area]\"]:checked').val() == 2) {
            $('.price_area').show();
        }
    });
    $('input:radio[name="ProductForm[time_to_sell]"]').change(function () {
        if ($('input[name="ProductForm[time_to_sell]"]:checked').val() == 1) {
            $('.time_to_sell').hide();
            $("#productform-time_begin").removeAttr("required");
            $("#productform-time_end").removeAttr("required");
        }
        if ($('input[name="ProductForm[time_to_sell]"]:checked').val() == 2) {
            $('.time_to_sell').show();
            $("#productform-time_begin").attr("required", "required");
            $("#productform-time_end").attr("required", "required");
        }
    });
    $(".weight").hide();
    $(".weight-<?= $model->category_id ?>").attr("style", "block");
    $("#product-category").on("change", function () {
        var id = $("#product-category option:selected").val();

        $(".weight-" + id).attr("style", "block");
    });
    function getUnit(id) {
        var unit = <?php echo json_encode($unit) ?>;
        var option = '';
        for (var key in unit) {
            if (key == id) {
                for (var i = 0; i < unit[key].length; i++) {
                    option += '<option value=' + unit[key][i] + '>' + unit[key][i] + '</option>';
                }
            }
        }
        return option;
    }
    function getOsUnit(id) {
        var unit = <?php echo json_encode($os_unit) ?>;
        var option = '';
        for (var key in unit) {
            if (key == id) {
                for (var i = 0; i < unit[key].length; i++) {
                    option += '<option value=' + unit[key][i] + '>' + unit[key][i] + '</option>';
                }

            }
        }
        return option;
    }
    function getProductType(id) {
        var product_type = <?php echo json_encode($product_type) ?>;
        var option = '';
        for (var key in product_type) {
            if (key == id) {
                for (var i = 0; i < product_type[key].length; i++) {
                    option += '<option value=' + product_type[key][i].id + '>' + product_type[key][i].title + '</option>';
                }

            }
        }
        return option;
    }

    $('#productform-time_begin').datepicker({
        dateFormat: 'dd/mm/yy',
        autoclose: true,
        startDate: new Date(),
        todayHighlight: true,
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        onSelect: function (date) {
            var product_time_end = $('#productform-time_end');
            var minDate = $(this).datepicker('getDate');
            var maxDate = new Date('<?= $time_begin ?>');
            if ((maxDate.getTime() - minDate.getTime()) <= 25200000) {
                product_time_end.datepicker('setDate', minDate);
                minDate.setDate(minDate.getDate() + 1);
                product_time_end.datepicker('option', 'minDate', minDate);
            }
        }
    });
    $('#productform-time_end').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        todayHighlight: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date('<?= \Yii::$app->formatter->asDatetime((strtotime($time_end)), "php:Y-m-d") ?>'),
    });
    $('#submit-product-form').on('click', function () {
        var count_img = $("#result > div").length;
        if (count_img >= 3) {
            $("#product-form").submit();
        } else {
            $(".msg_img").addClass("text-danger");
        }
        return false;
    });

    $(document).on('click', '.btn_delete', function (event) {
        $(this).parent().parent().remove();
    });


</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
