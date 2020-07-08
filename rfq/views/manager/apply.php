<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use rfq\widgets\SidebarWidget;
use common\components\Constant;
use yii\grid\GridView;
use yii\helpers\Html;

SidebarWidget::widget();
?>
<?= SidebarWidget::widget() ?>
<div class="container">
    <h2 class="section-title"><?= $this->title ?></h2>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'tableOptions' => ['class' => 'table table-bordered table_responsive table-striped'],
        'emptyText' => Yii::t('rfq', 'Chưa có báo giá nào !'),
        'columns' => [
            [
                'attribute' => Yii::t('rfq', 'Tên sản phẩm'),
                'format' => 'raw',
                'value' => function($data) {
                    return data(Yii::t('rfq', 'Tên sản phẩm'), $data['rfq']['title']);
                },
            ],
            [
                'attribute' => Yii::t('rfq', 'Ngày mua / hết hạn'),
                'format' => 'raw',
                'value' => function($data) {
                    return data(Yii::t('rfq', 'Ngày mua / hết hạn'), \Yii::$app->formatter->asDatetime($data['rfq']['date_start'], "php:d/m/Y") . ' - ' . \Yii::$app->formatter->asDatetime($data['rfq']['date_end'], "php:d/m/Y"));
                },
            ],
            [
                'attribute' => Yii::t('rfq', 'Số lượng'),
                'format' => 'raw',
                'value' => function($data) {
                    return data(Yii::t('rfq', 'Số lượng'), $data['rfq']['quantity'] . ' ' . Yii::t('rfq', $data['rfq']['unit']));
                },
            ],
            [
                'attribute' => Yii::t('rfq', 'Bạn báo giá'),
                'format' => 'raw',
                'value' => function($data) {
                    return data(Yii::t('rfq', 'Bạn báo giá'), Constant::price($data['price']) . ' vnđ');
                },
            ],
            [
                'attribute' => Yii::t('rfq', 'Trạng thái'),
                'format' => 'raw',
                'value' => function($data) {
                    $html = '<p class="status-request">' . Constant::STATUS_SHOW_APPLY[$data['status']];
                    if (\Yii::$app->user->id == $data['actor']['id'] && $data['status'] == Constant::STATUS_PENDING) {
                        $html .= Html::a('<i class="fas fa-times-circle" style="color: #f44336;"></i> ' . Yii::t('rfq', 'Hủy'), '/manager/cancel/' . (string) $data['_id'], [
                                    'title' => Yii::t('rfq', 'Hủy'),
                                    'data-confirm' => Yii::t('rfq', 'Bạn có muốn hủy báo giá này ?'),
                                    'data-method' => 'post',
                                    'class' => 'btn btn-xs btn-danger btn-cancel-apply'
                        ]);
                    }
                    $html .= '</p>';
                    return data(Yii::t('rfq', 'Trạng thái'), $html);
                },
            ],
        ],
    ]);
    ?>
</div>

<?php
ob_start();

function data($title, $content) {
    $html = '<div class="left">';
    $html .= '<strong>' . $title . ': </strong>';
    $html .= '</div>';
    $html .= '<div class="right">';
    $html .= $content;
    $html .= '</div>';
    $html .= '<div style="clear: both;"></div>';
    return $html;
}
?>
<script>
    $('body').on('click', '.offer-view', function (event) {
        $('#modalHeader').find('span').html('');
        $('#modalHeader').prepend('<span>' + $(this).attr('data-title') + '</span>');
        $.get($(this).attr('href'), function (data) {
            $('#modal-apply').modal('show').find('#modalContent').html(data)
        });
        return false;
    });

    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal-apply',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>
