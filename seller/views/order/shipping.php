<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$form = ActiveForm::begin([
            'id' => 'form-date',
            'layout' => 'horizontal',
        ])
?>
<?=
$form->field($model, 'date_begin', [
    'template' => '{label}<div class="col-sm-5 col-xs-8">{input}{error}{hint}</div><div class="col-sm-3 col-xs-4">' . Html::dropDownList('ProductOrderForm[time_begin]', null, $model->time(), ['class' => 'form-control']) . '</div>',
])->textInput()
?>
<?=
$form->field($model, 'date_end', [
    'template' => '{label}<div class="col-sm-5 col-xs-8">{input}{error}{hint}</div><div class="col-sm-3 col-xs-4">' . Html::dropDownList('ProductOrderForm[time_end]', null, $model->time(), ['class' => 'form-control']) . '</div>',
])->textInput()
?>
<br>
<h4>Nếu cần tìm kiếm vận chuyển vui lòng nhập đủ thông tin dưới đây: </h4>
<br>
<?=
$form->field($model, 'carType', [
    'template' => '{label}<div class="col-sm-8 col-xs-12">{input}{error}{hint}</div>',
])->dropDownList($model->carType(), ['prompt' => 'Chọn loại xe']);
?>
<?=
$form->field($model, 'mass', [
    'template' => '{label}<div class="col-sm-5 col-xs-8">{input}{error}{hint}</div><div class="col-sm-3 col-xs-4">' . Html::dropDownList('ProductOrderForm[unit]', $model->unit, ['Tấn' => 'Tấn', 'Kg' => 'Kg'], ['id' => 'unit', 'class' => 'form-control']) . '</div>',
])->textInput(['placeholder' => 'Nhập khối lượng'])
?>
<?=
$form->field($model, 'transport_price', [
    'template' => '{label}<div class="col-sm-8 col-xs-12">{input}{error}{hint}</div>',
])->textInput()
?>
<?=
$form->field($model, 'vat')->checkbox(['template' => '<div class="col-xs-12 col-sm-offset-4">{input} {label}</div>'])->label('Cần hóa đơn VAT')
?>
<?php ActiveForm::end() ?>
<?php
$time_begin = \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d");
$time_end = \Yii::$app->formatter->asDatetime(time(), "php:Y-m-d");
?>
<?php ob_start(); ?>
<script type="text/javascript">
    $('.select2-select').select2({});
    $('#productorderform-date_begin').datepicker({
        dateFormat: 'dd/mm/yy',
        autoclose: true,
        startDate: new Date(),
        todayHighlight: true,
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        onSelect: function (date) {
            var product_time_end = $('#productorderform-date_end');
            var minDate = $(this).datepicker('getDate');
            var maxDate = new Date('<?= $time_begin ?>');
            if ((maxDate.getTime() - minDate.getTime()) <= 25200000) {
                product_time_end.datepicker('setDate', minDate);
                minDate.setDate(minDate.getDate());
                product_time_end.datepicker('option', 'minDate', minDate);
            }
        }
    });
    $('#productorderform-date_end').datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        todayHighlight: true,
        changeMonth: true,
        changeYear: true,
        minDate: new Date('<?= \Yii::$app->formatter->asDatetime((strtotime($time_end)), "php:Y-m-d") ?>'),
    });
    $('body').on('click', '#sending-confirm', function () {
        var date_begin = $("#productorderform-date_begin").val();
        if (date_begin == "") {
            $(".field-productorderform-date_begin").addClass("has-error");
            $(".field-productorderform-date_begin p").html('Thời gian giao hàng không đưọc bỏ trống');
            return false;
        }
        $.ajax({
            type: "POST",
            url: '/ajax/shipping/<?= $model->id ?>',
            data: $("#form-date").serialize(),
            success: function (data) {
                $(".field-productorderform-date_end").addClass("has-error");
                $(".field-productorderform-date_end p").html(data);
            },
        });

        return false;
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>