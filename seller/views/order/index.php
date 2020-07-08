<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = $this->title;
?>


<?php
$form = ActiveForm::begin([
            'id' => 'formFilter',
            'method' => 'get',
            'action' => ['index'],
            'options' => [
                'class' => 'form-inline'
            ]
        ]);
?>
<div class="row">
    <div class="col-sm-12 list-order">
        <div class="form-group" style="margin-bottom: 5px">
            <a href="/order/index" class="btn btn-default">Đang xử lý (<?= $order->countStatus(Constant::STATUS_ORDER_PENDING) ?>)</a>
            <a href="/order/sending" class="btn btn-default">Đang giao hàng (<?= $order->countStatus(Constant::STATUS_ORDER_SENDING) ?>)</a>
            <a href="/order/finish" class="btn btn-default">Đã thành công (<?= $order->countStatus(Constant::STATUS_ORDER_FINISH) ?>)</a>
            <a href="/order/unsuccessful" class="btn btn-default">Không thành công (<?= $order->countStatus(Constant::STATUS_ORDER_UNSUCCESSFUL) ?>)</a>
            <a href="/order/block" class="btn btn-default">Đã hủy (<?= $order->countStatus(Constant::STATUS_ORDER_BLOCK) ?>)</a>
        </div>
    </div>
</div>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{pager}",
    'tableOptions' => ['class' => 'table table-bordered table-customize table-responsive'],
    'emptyText' => 'Chưa có đơn hàng nào.',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
        [
            'attribute' => 'Mã đơn hàng',
            'format' => 'raw',
            'value' => function($data ) {
                $html = '<div class="left">';
                $html .= '<strong>Mã đơn hàng: </strong>';
                $html .= '</div>';
                $html .= '<div class="right">';
                $html .= $data['invoice_code'];
                $html .= '</div>';
                $html .= '<div style="clear: both;"></div>';
                return $html;
            },
        ],
        [
            'attribute' => 'Người mua',
            'format' => 'raw',
            'value' => function($data) {
                $html = '<div class="left">';
                $html .= '<strong>Người mua: </strong>';
                $html .= '</div>';
                $html .= '<div class="right">';
                $html .= '<ul>';
                $html .= '<li>Họ tên: <a target="_blank" href="' . Yii::$app->setting->get('siteurl') . '/user/view/' . $data['buyer']['id'] . '">' . $data['buyer']['name'] . '</a></li>';
                $html .= '<li>Điện thoại: ' . $data['buyer']['phone'] . '</li>';
                $html .= '<li>Địa chỉ: ' . $data['buyer']['address'] . ',' . $data['buyer']['ward'] . ',' . $data['buyer']['district'] . ',' . $data['buyer']['province'] . '</li>';
                $html .= '</ul>';
                $html .= '</div>';
                $html .= '<div style="clear: both;"></div>';


                return $html;
            }
        ],
        [
            'attribute' => 'Thông tin đơn hàng',
            'format' => 'raw',
            'value' => function($data) {
                $html = '<div class="left">';
                $html .= '<strong>Thông tin đơn hàng: </strong>';
                $html .= '</div>';
                $html .= '<div class="right">';
                $html .= '<ul>';
                foreach ($data['product'] as $k => $value) {
                    $i = $k + 1;
                    $html .= '<li>' . $i . '. <a href="' . Yii::$app->setting->get('siteurl') . '/' . $value['slug'] . '-' . $value['id'] . '"><strong>' . $value['title'] . (($value['type'] != 0) ? " Loại " . $value['type'] : "") . '</strong></a> (' . $value['quantity'] . ' ' . $value['unit'] . ' x ' . Constant::price($value['price']) . ')';
                    if ($value['status'] == 0 && $data['status'] == Constant::STATUS_ORDER_PENDING) {
                        $html .= '<small class="text-danger"> (Không đủ số lượng để giao)</small>';
                    } else if ($value['status'] == 0 && $data['status'] != Constant::STATUS_ORDER_PENDING) {
                        $html .= '<small class="text-danger">(Sản phẩm không giao được)</small>';
                    }
                    $html .= '</li>';
                }
                if (!empty($data['date_begin']) && $data['status'] != Constant::STATUS_ORDER_PENDING) {
                    $html .= '<hr style="margin:10px 0"><li>Thông tin vận chuyển: </li>';
                    $html .= '<li>Thời gian giao/nhận: ' . date('d/m/Y H:i', $data['date_begin']) . ' - ' . date('d/m/Y H:i', $data['date_end']) . '</li>';
                    $html .= !empty($data['transport'])?'<li>Người vận chuyển: ' . $data['transport'] . '</li>':'';
                }
                $html .= '</ul>';
                $html .= '</div>';
                $html .= '<div style="clear: both;"></div>';


                return $html;
            }
        ],
        [
            'attribute' => 'Tổng tiền',
            'format' => 'raw',
            'value' => function($data ) {
                $total = 0;
                foreach ($data['product'] as $k => $value) {
                    $total += $value['quantity'] * $value['price'];
                }
                $html = '<div class="left">';
                $html .= '<strong>Tổng tiền: </strong>';
                $html .= '</div>';
                $html .= '<div class="right">';
                $html .= Constant::price($total);
                $html .= '</div>';
                $html .= '<div style="clear: both;"></div>';
                return $html;
            },
        ],
        [
            'attribute' => 'Trạng thái',
            'format' => 'raw',
            'value' => function($data ) {
                switch ($data['status']) {
                    case Constant::STATUS_ORDER_PENDING:
                        $html = '<select id="status" data-status="' . Constant::STATUS_ORDER_PENDING . '" class="form-control" data-code="' . $data['code'] . '">';
                        $html .= '<option>Chọn xử lý ...</option>';
                        $html .= '<option value="' . Constant::STATUS_ORDER_SENDING . '">Bắt đầu giao hàng</option>';
                        $html .= '<option value="' . Constant::STATUS_ORDER_BLOCK . '">Huỷ đơn hàng</option>';
                        $html .= '</select>';
                        $time = date('Y-m-d H:i:s', $data->created_at + (24 * 3600));
                        ob_start();
                        ?>
                        <script type="text/javascript">
                            $("#countdown-<?= $data->id ?>").countdown("<?= $time ?>", function (event) {
                                var totalHours = event.offset.totalDays * 24 + event.offset.hours;
                                $(this).html(event.strftime('<small style="color:red">Còn ' + totalHours + "h%M' nữa sẽ tự động huỷ.</small>"));
                            });
                        </script>
                        <?php
                        $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean()));
                        $html .= '<br><small>Ngày đặt hàng: ' . date('d/m/Y H:i:s', $data->created_at) . '</small>';
                        $html .= '<div class="count-time" id="countdown-' . $data->id . '"></div>';
                        return $html;
                        break;
                    case Constant::STATUS_ORDER_SENDING:
                        $html = '<select id="status" data-status="' . Constant::STATUS_ORDER_SENDING . '" class="form-control" data-code="' . $data['code'] . '">';
                        $html .= '<option>Chọn xử lý ...</option>';
                        $html .= '<option value="' . Constant::STATUS_ORDER_FINISH . '">Giao thành công</option>';
                        $html .= '<option value="' . Constant::STATUS_ORDER_UNSUCCESSFUL . '">Giao không thành công</option>';
                        $html .= '</select>';

                        return $html;
                        break;
                    case Constant::STATUS_ORDER_UNSUCCESSFUL:
                        return '<a href="javascript:void(0)" class="order-unsuccessful"><p class="text-primary"><span class="glyphicon glyphicon-exclamation-sign"></span> Không thành công</p></a>';
                        break;
                    case Constant::STATUS_ORDER_BLOCK:
                        return '<a href="javascript:void(0)" class="order-block"><p class="text-danger"><span class="fa fa-remove"></span> Đã huỷ</p></a>';
                        break;
                    case Constant::STATUS_ORDER_FINISH:
                        return '<p class="text-success"><span class="fa fa-check"></span> Đã thành công</p>';
                        break;
                }
            },
            'headerOptions' => ['width' => 100]
        ],
    ],
]);
?>

<?php ActiveForm::end(); ?>
<?php ob_start(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#formFilter").on("change", "#orderfilter-status", function () {
            $("#formFilter").submit();
        });
    });
    $(document).ready(function () {

        var url = window.location.href;
        $(".list-order a").each(function () {
            if (url == (this.href)) {
                $(this).css('background', '#e6e6e6');
            }
        });

        $("#formFilter").on("change", "#status", function () {
            var code = $(this).attr("data-code");
            var val = parseInt($(this).val());
            var status = parseInt($(this).attr("data-status"));
            if (val == <?= Constant::STATUS_ORDER_SENDING ?>) {
                $(".modal-footer").show();
                $('#modalHeader span').html('<b>Thời gian giao/nhận hàng</b><br/><b>Mã đơn hàng: </b> #' + code);
                $.get('/order/shipping/' + code, function (data) {
                    $('#modal-order').modal('show').find('#modalContent').html(data)
                });
            } else if (val == <?= Constant::STATUS_ORDER_BLOCK ?>) {
                $.get('/order/blockform/' + code, function (data) {
                    $('#modal-order').find('.modal-header span').html('Hủy đơn hàng: #<b>' + code + '</b>');
                    $('#modal-order').modal('show').find('#modalContent').html(data);
                    $('#modal-order').find('.modal-footer').html('<button id="sending-confirm" type="button" class="btn btn-success block-btn">Đồng ý</button>')
                });
            } else if (val == <?= Constant::STATUS_ORDER_UNSUCCESSFUL ?>) {
                $.get('/order/unsuccessfulform/' + code, function (data) {
                    $('#modal-order').find('.modal-header span').html('Đơn hàng giao không thành công!<br>Mã đơn hàng: #<b>' + code + '</b>');
                    $('#modal-order').modal('show').find('#modalContent').html(data);
                    $('#modal-order').find('.modal-footer').html('<button id="sending-confirm" type="button" class="btn btn-success unsuccessful-btn">Đồng ý</button>')
                });
            } else if (val == <?= Constant::STATUS_ORDER_FINISH ?>) {
                $.get('/order/finishform/' + code, function (data) {
                    $('#modal-order').find('.modal-header span').html('Đơn hàng thành công: #<b>' + code + '</b>');
                    $('#modal-order').modal('show').find('#modalContent').html(data);
                    $('#modal-order').find('.modal-footer').html('<button id="sending-confirm" type="button" class="btn btn-success finish-btn">Đồng ý</button>')
                });
            }
        });

        $("body").on("click", ".block-btn, .unsuccessful-btn, .finish-btn", function (event) {
            $('form#order-form').submit();
        })
    })
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span></span>',
    'footer' => '<button id="sending-confirm" type="button" class="btn btn-success btn-transport">Đồng ý</button>',
    'id' => 'modal-order',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div id='modalContent'>

</div>
<?php
yii\bootstrap\Modal::end();
?>
