<?php

use yii\bootstrap\ActiveForm;

$this->title = 'Giỏ hàng';
$this->params['breadcrumbs'][] = $this->title;
$province = Yii::$app->province;
?>

<?php

$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'id' => 'formShipping',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-sm-4',
                    'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-8',
                ],
            ],
        ]);
?>

<?= $form->field($model, 'name')->textInput(['placeholder' => \Yii::t('common', 'Họ và tên')])->label(\Yii::t('common', 'Họ và tên')) ?>
<?= $form->field($model, 'phone')->textInput(['placeholder' => \Yii::t('common', 'Số điện thoại')])->label(\Yii::t('common', 'Số điện thoại')) ?>

<?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']) ?>
<?php

$array = [];
foreach ($province->getProvinces() as $value) {
    $array[(string) $value['_id']] = $value['name'];
}
$district = [];
$ward = [];
if (!empty($model->province)) {
    foreach ($province->getDistricts($model->province) as $value) {
        $district[(string) $value['_id']] = $value['name'];
    }
}
if (!empty($model->district)) {
    foreach ($province->getWards($model->district) as $value) {
        $ward[$value['slug']] = $value['name'];
    }
}
?>
<?= $form->field($model, 'province')->dropDownList($array, ['class' => 'form-control select2-select', 'style' => 'width:200px', 'prompt' => \Yii::t('common', 'Tỉnh/thành')])->label(\Yii::t('common', 'Tỉnh/thành')) ?>

<?= $form->field($model, 'district')->dropDownList($district, ['class' => 'form-control select2-select', 'style' => 'width:200px', 'prompt' => \Yii::t('common', 'Quận/huyện')])->label(\Yii::t('common', 'Quận/huyện')) ?>

<?= $form->field($model, 'ward')->dropDownList($ward, ['class' => 'form-control select2-select', 'style' => 'width:200px', 'prompt' => \Yii::t('common', 'Phường/xã')])->label(\Yii::t('common', 'Phường/xã')) ?>

<?= $form->field($model, 'address')->textInput(['placeholder' => \Yii::t('common', 'Địa chỉ (Số nhà, đường)')])->label(\Yii::t('common', 'Địa chỉ (Số nhà, đường)')) ?>

<?php

ActiveForm::end();
?>

<?php ob_start(); ?>
<script type="text/javascript">
    $(".select2-select").select2({
        //here my options
    }).on("select2:opening",
            function () {
                $("#modal-order").removeAttr("tabindex", "-1");
            }).on("select2:close",
            function () {
                $("#modal-order").attr("tabindex", "-1");
            });

    $("#invoice-province").on("change", function (event, state) {
        $.ajax({
            type: "GET",
            url: "/ajax/district/" + $("#invoice-province option:selected").val(),
            success: function (data) {
                var option = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value=' + data[i]._id + '>' + data[i].name + '</option>';
                    }
                    $("#invoice-district").html(option);
                    var option_ward = '';
                    if (data[0].ward.length > 0) {
                        for (var i = 0; i < data[0].ward.length; i++) {
                            option_ward += '<option value=' + data[0].ward[i].slug + '>' + data[0].ward[i].name + '</option>';
                        }
                    }
                } else {
                    option_ward += '<option value>'+'<?= \Yii::t('common', 'Phường/xã') ?>'+'</option>';
                    option += '<option value>'+'<?= \Yii::t('common', 'Quận/huyện') ?>'+'</option>';
                }
                $("#invoice-ward").html(option_ward);
            },
        });
    });
    $("#invoice-district").on("change", function (event, state) {
        $.ajax({
            type: "GET",
            url: "/ajax/ward/" + $("#invoice-district option:selected").val(),
            success: function (data) {
                var option = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value=' + data[i].slug + '>' + data[i].name + '</option>';
                    }
                } else {
                    option += '<option value>'+'<?= \Yii::t('common', 'Phường/xã') ?>'+'</option>';
                }
                $("#invoice-ward").html(option);
            },
        });
    });
    $('.quantity').on('keyup keypress blur change', function (e) {
        var q = parseInt($(this).attr('max'));
        var val = parseInt($(this).val());
        if (val > q) {
            $(this).val(q);
            return false;
        }

    });
    $('.number').on('change', function (e) {
        var id = $(this).attr("data-id");
        var val = ($(this).val());
        $.ajax({
            type: "POST",
            url: "/cart/changequantity",
            data: {id: id, quantity: val},
            success: function (data) {
                if (data.error != "") {
                    $("#msg-" + id + " small").html(data.error);
                } else {
                    $("#msg-" + id + " small").html("");
                    $("#number-" + id).val(data.quantity);
                    $(".header-cart .circle").html(data.count);
                    $(".header-cart .price-value").html(data.total);
                    $(".total span").html(data.total);
                }
            },
        });

    })
    $(".abate, .augment").on("click", function (event, state) {
        var type = $(this).attr("data-type");
        var id = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "/cart/number",
            data: {id: id, type: type},
            success: function (data) {
                if (data.error != "") {
                    $("#msg-" + id + " small").html(data.error);
                } else {
                    $("#msg-" + id + " small").html("");
                    if (data.quantity > 1) {
                        $(".quantity_" + id + " .abate").removeClass("none");
                    } else {
                        $(".quantity_" + id + " .abate").addClass("none");
                    }
                    $("#number-" + id).val(data.quantity);
                    $(".header-cart .circle").html(data.count);
                    $(".header-cart .price-value").html(data.total);
                    $(".total span").html(data.total);
                }
            },
        });
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>