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

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{summary}\n{pager}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
        [
            'attribute' => 'code',
            'format' => 'raw',
            'value' => function($data) {
                return '<a class="code" href="#">' . $data->invoice_code . '</a>';
            },
        ],
        [
            'attribute' => 'Thông tin người bán',
            'headerOptions' => ['style' => 'width:30%'],
            'format' => 'raw',
            'value' => function($data) {
                $html = '<ul>';
                $html .= '<li>Họ tên: ' . $data->owner['fullname'] . '</li>';
                 $html .= '<li>Tên cơ sở: <a target="_blank" href="'.Yii::$app->setting->get("siteurl").'/nha-vuon/'.$data->owner['username'].'">' . $data->owner['garden_name'] . '</a></li>';
                $html .= '<li>Địa chỉ: ' . $data->owner['address'].', '.$data->owner['ward']['name'].', '.$data->owner['district']['name'].', '.$data->owner['province']['name'].'</li>';
                $html .= '</ul>';
                return $html;
            }
        ],
        [
            'attribute' => 'Thông tin người mua',
            'format' => 'raw',
            'headerOptions' => ['style' => 'width:30%'],
            'value' => function($data) {
                $html = '<ul>';
                $html .= '<li>Họ tên: <a target="_blank" href="'.Yii::$app->setting->get('siteurl').'/user/view/'.$data->buyer['id'].'">' . $data->buyer['name'] . '</a></li>';
                $html .= '<li>Điện thoại: ' . $data->buyer['phone'] . '</li>';
                $html .= '<li>Địa chỉ: ' . $data->buyer['address'].', '.$data->buyer['ward'].', '.$data->buyer['district'].', '.$data->buyer['province']. '</li>';
                $html .= '</ul>';
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
                $html = Constant::price($total)." VNĐ";
                return $html;
            },
        ],
    
        [
            'attribute' => 'Ngày mua',
            'format' => 'raw',
            'value' => function($data) {
                return date('d/m/Y', $data->created_at);
            },
        ],

        [
            'attribute' => '',
            'format' => 'raw',
            'value' => function($data) {
                $html = '<a data-title="Chi tiết đơn hàng" href="/order/view/'.$data->id.'" class="view-order">Chi tiết</a>';
                if($data->status == Constant::STATUS_ORDER_UNSUCCESSFUL || $data->status == Constant::STATUS_ORDER_BLOCK){
                   $html .= ' | <a data-title="Lý do" href="/order/reason/'.$data->id.'" class="view-reason">Lý do</a>'; 
                }
                return $html;
            },
        ],
    ],
]);
?>
<?php ActiveForm::end(); ?>
<?php Pjax::end() ?> 
<?php ob_start(); ?>
<script type="text/javascript">
    $('body').on('click', '.view-order, .view-reason', function(event) {
            $('#modalHeader span').html('<b>'+$(this).data('title')+'</b>');
            $.get($(this).attr('href'), function(data) {
              $('#modal-order').modal('show').find('#modalContent').html(data)
           });
           return false;
        });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span></span>',
    'id' => 'modal-order',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div id='modalContent'>

</div>


<?php
yii\bootstrap\Modal::end();
?>