<?php

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\components\Constant;

$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([]); ?>

<!-- Material checked -->

<div class="payment_setting">
    <h4><b>Cài đặt hình thức thanh toán</b></h4>
    <p><i>Hãy lựa chọn hình thức thanh toán mà bạn có thể sử dụng.</i></p>

    <div class="method_payment">

        <?php
        $id = [];
        if (!empty($model['payment'])) {
            foreach ($model['payment'] as $key => $value) {
                $id[] = $value['id'];
                if (!empty($value['percent'])) {
                    $percent = $value['percent'];
                }
            }
        }
        ?>


        <p class="payment_title"><input <?= (in_array(1, $id) ? "checked" : "") ?> name="payment" value="1" class="payment" type="checkbox" data-toggle="toggle" data-on="Bật"  data-off="Tắt" data-onstyle="success" data-offstyle="danger" data-title="Thanh toán khi nhận hàng"> <b>Thanh toán khi nhận hàng</b></p>
        <p ><span class="note">Thanh toán cho nhân viên giao hàng hoặc nhà xe khi nhận hàng.</span></p>
    </div>

    <div class="method_payment_form">
        <p class="payment_title"><input value="2" <?= (in_array(2, $id) ? "checked" : "") ?> name="payment_percent" class="payment_form" type="checkbox" data-toggle="toggle" data-on="Bật" data-off="Tắt" data-onstyle="success" data-offstyle="danger" data-title="Chuyển khoản trước "> <b>Chuyển khoản trước <?= (!empty($percent) ? $percent : "[x]") ?>%</b></p>
        <div class="payment_content">
            <div class="left">Nhập % chuyển trước</div><div class="right"><input class="form-control percent" width="20px" type="number" name="percent"></div><div><a href="javascript:void(0)" class="btn btn-success btn_payment">Xác nhận</a></div>
            <div style="clear: both;"></div>
            <p class="message"></p>
        </div>

        <p><span class="note">Người bán yêu cầu người mua chuyển khoản trước</span> <?= !empty($percent) ? $percent : "x" ?>%.</p>
    </div>

    <div class="method_payment">
        <p class="payment_title"><input value="3" <?= (in_array(3, $id) ? "checked" : "") ?> name="payment_after" class="payment" type="checkbox" data-toggle="toggle" data-on="Bật" data-off="Tắt" data-onstyle="success" data-offstyle="danger" data-title="Thanh toán sau khi nhận hàng"> <b>Thanh toán sau khi nhận hàng</b></p>
        <p ><span class="note">Người bán sẽ gửi hàng trước, người mua nhận hàng rồi mới thanh toán.</span></p>
    </div>

</div>




<?php ActiveForm::end(); ?>
<?php ob_start(); ?>
<script type="text/javascript">
    $('body').on('change', '.payment', function (event) {
        id = parseInt($(this).val());
        var title = $(this).data('title');
        var note = $(this).closest('.method_payment').find('.note').html();
        if (this.checked) {
            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(["payment/index"]); ?>',
                type: 'post',
                data: 'id=' + id + '&title=' + title + '&note=' + note,
                success: function (data) {

                }
            });
        } else {
            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(["payment/index"]); ?>',
                type: 'post',
                data: 'id=' + id + '&title=' + title + '&note=' + note,
                success: function (data) {

                }
            });
        }
    });

    $('body').on('change', '.payment_form', function (event) {
        id = parseInt($(this).val());
        var title = $(this).data('title');
        var note = $(this).closest('.method_payment_form').find('.note').html();
        if (this.checked) {
            $(this).closest('.method_payment_form').find('.payment_content').fadeIn();
            $('body').on('click', '.btn_payment', function (e) {
                percent = parseInt($('.percent').val());
                if (isNaN(percent)) {
                    $('.message').addClass('text-danger').html('Không được bỏ trống');
                    $('.message').css('color', '#a94442');
                    return false;
                } else {
                    $('.message').html('');
                    $.ajax({
                        url: '<?= Yii::$app->urlManager->createUrl(["payment/index"]); ?>',
                        type: 'post',
                        data: 'id=' + id + '&title=' + title + '&note=' + note + '&percent=' + percent,
                        success: function (data) {
                            $('.message').addClass('text-success').html('Thêm thành công');
                            location.reload();
                        }
                    });
                }
            });
        } else {
            $(this).closest('.method_payment_form').find('.payment_content').fadeOut();
            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(["payment/index"]); ?>',
                type: 'post',
                data: 'id=' + id + '&title=' + title + '&note=' + note,
                success: function (data) {

                }
            });
        }
    });


    $('body').on('click', '.create', function (event) {
        event.preventDefault();
        $('#modalHeader span').html('<b>Thêm mới</b>');
        $.get($(this).attr('href'), function (data) {
            $('#modal-payment').modal('show').find('#modalContent').html(data)
        });
    });

    $('body').on('click', '.update, .delete', function (event) {
        event.preventDefault();
        $('#modalHeader span').html('<b>' + $(this).data('title') + '</b>');
        $.get($(this).attr('href'), function (data) {
            $('#modal-payment').modal('show').find('#modalContent').html(data)
        });
    });
    
     $(function () {
       $( ".percent" ).change(function() {
          var max = 100;
          var min = 1;
          if ($(this).val() > max)
          {
              $(this).val(max);
          }
          else if ($(this).val() < min)
          {
              $(this).val(min);
          }       
        }); 
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span></span>',
    'id' => 'modal-payment',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div id='modalContent'>

</div>
<?php
yii\bootstrap\Modal::end();
?>