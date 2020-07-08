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
Pjax::begin([
    'id' => 'pjax_gridview_order',
])
?>
<?php
$form = ActiveForm::begin([
            'id' => 'orderAction',
            'action' => ['doaction'],
            'options' => [
                'class' => 'form-inline'
            ]
        ]);
?>
<div class="">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'tableOptions' => ['class' => 'table table-bordered table-customize table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
            [
                'attribute' => 'Thông tin người mua',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '<div class="left">';
                    $html .= '<strong>Thông tin người mua: </strong>';
                    $html .= '</div>';
                    $html .= '<div class="right">';
                    $html .= '<ul>';
                    $html .= '<li>Họ tên: ' . $data['order']['name'] . '</li>';
                    $html .= '<li>Điện thoại: ' . $data['order']['phone'] . '</li>';
                    $html .= '<li>Địa chỉ: ' . $data['order']['address'] . ',' . $data['order']['ward'] . ',' . $data['order']['district'] . ',' . $data['order']['province'] . '</li>';
                    $html .= '</ul>';
                    $html .= '</div>';
                    $html .= '<div style="clear: both;"></div>';


                    return $html;
                }
            ],
            [
                'attribute' => 'Tên sản phẩm',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '<div class="left">';
                    $html .= '<span><strong>Tên sản phẩm: </strong></span>';
                    $html .= '</div>';
                    $html .= '<div class="right">';
                     $html .= '<a href="#">' . $data['product']['title'] . '</a><br>' . $data['product']['type'];
                    $html .= '</div>';
                    $html .= '<div style="clear: both;"></div>';
                    return $html;
                },
            ],
            [
                'attribute' => 'Số lượng',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '<div class="left">';
                    $html .= '<span><strong>Số lượng: </strong></span>';
                    $html .= '</div>';
                    $html .= '<div class="right">';
                    $html .= Constant::unit($data['product']['quantity']);
                    $html .= '</div>';
                    $html .= '<div style="clear: both;"></div>';
                    return $html;
                },
            ],
            [
                'attribute' => 'Giá sản phẩm',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '<div class="left">';
                    $html .= '<span><strong>Giá sản phẩm: </strong></span>';
                    $html .= '</div>';
                    $html .= '<div class="right">';
                    $html .= number_format($data['product']['price']) . ' VNĐ';
                    $html .= '</div>';
                    $html .= '<div style="clear: both;"></div>';
                    return $html;
                },
            ],
            [
                'attribute' => 'Ngày giao',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '<div class="left">';
                    $html .= '<span><strong>Ngày giao: </strong></span>';
                    $html .= '</div>';
                    $html .= '<div class="right">';
                    $html .= $data['datetime_begin'];
                    $html .= '</div>';
                    $html .= '<div style="clear: both;"></div>';
                    return $html;
                },
            ],
            [
                'attribute' => 'Tổng tiền',
                'format' => 'raw',
                'value' => function($data) {
                    $html = '<div class="left">';
                    $html .= '<span><strong>Tổng tiền: </strong></span>';
                    $html .= '</div>';
                    $html .= '<div class="right">';
                    $html .= Constant::price($data['product']['price'] * $data['product']['quantity']) . ' VNĐ';
                    $html .= '</div>';
                    $html .= '<div style="clear: both;"></div>';
                    return $html;
                }
            ],
            [
                'attribute' => 'Xử lý',
                'format' => 'raw',
                'value' => function($data) {

                    // $html += '<p><a id="status-' . (string) $data['_id'] . '" href="/order/status/' . (string) $data['_id'] . '" class="btn btn-success order-status" data-title="' . $data['product']['title'] . '">Chuẩn bị hàng</a><p>';
                    $html = '<div class="dropdown dropdown-action">
  <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
    Hành động
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-action">
    <li><a href="/order/statuspending/' . (string) $data['_id'] . '">Chưa giao</a></li>
    <li><a href="/order/statuscomplete/' . (string) $data['_id'] . '">Đã giao</a></li>
    <li>' . Html::a('Xoá', ['remove', 'id' => (string) $data['_id']], [
                                'data' => [
                                    'confirm' => 'Bạn có muốn xoá đơn hàng này không?',
                                    'method' => '',
                                ],
                            ]) . '</li>
  </ul>
</div>';

                    return $html;
                },
                'headerOptions' => ['width' => 150]
            ],
        ],
    ]);
    ?>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end() ?> 

<?php ob_start(); ?>
<script type="text/javascript">

    $('body').on('click', '#sending-confirm', function (event) {
        var id = $('#id-order').val();
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '/order/status/' + id,
            data: $("#form-date").serialize(),
            success: function (data) {
                $("#form-date").find('.errors').html(data);
            },
        });
        return false;
    });

    $('body').on('click', '.sending', function (event) {
        event.preventDefault();
        $('#modalHeader span').html($(this).data('title') + '!!');
        $.get($(this).attr('href'), function (data) {
            $('#modal-order').modal('show').find('#modalContent').html(data)
        });
    });

    $('body').on('change', '.have-car', function () {
        if ($(this).is(":checked")) {
            var id = $(this).data('id');
            var title = $(this).attr("data-title");
            $(".loader").show();
            $("#orderStatus").hide();
            $.ajax({
                type: "POST",
                url: '/ajax/havecar',
                data: 'id=' + id,
                success: function (data) {
                    $.pjax({container: '#pjax_gridview_order'});
                    $("#modalContent").html('<p>Bạn đã chuẩn bị hàng thành công!</p>');
                    $("#modalHeader span").html(title);
                    $('#modal-order').modal('show');
                },
            });

            return false;
        }
    });

    $('body').on('click', '.transport', function () {
        $("#modalHeader span").html('Danh sách xe vận chuyển');
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            success: function (data) {
                $('#modal-order').modal('show').find('#modalContent').html(data)
            },
        });

        return false;
    });
    $('body').on('click', '.order-status', function () {
        $("#modalHeader span").html($(this).attr("data-title"));
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            success: function (data) {
                $('#modal-order').modal('show').find('#modalContent').html(data)
            },
        });

        return false;
    });
    $('body').on('click', '.status_submit', function () {
        $(".loader").show();
        $("#orderStatus").hide();
        $.ajax({
            type: "POST",
            url: '/ajax/orderstatus',
            data: $("#orderStatus").serialize(),
            success: function (data) {
                $.pjax({container: '#pjax_gridview_order'});
                $("#modalContent").html('<p>Bạn đã chuẩn bị hàng thành công!</p>');
            },
        });

        return false;
    });
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
