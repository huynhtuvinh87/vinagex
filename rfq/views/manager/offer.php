<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use rfq\widgets\SidebarWidget;
use yii\grid\GridView;
use rfq\storage\RfqItem;
use common\components\Constant;
use yii\helpers\Html;

$item = new RfqItem($rfq);

SidebarWidget::widget();
?>
<?= SidebarWidget::widget() ?>
<div class="container">
    <h2 class="section-title"><?= $this->title ?></h2>
    <div class="list_item">
        <div class="row">
            <?php if (!empty($rfq['images'])) { ?>
                <div class="col-md-2">
                    <div class="img-rfq">
                        <div class="slider slider-single">
                            <?php foreach ($rfq['images'] as $value) { ?>
                                <a href="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . $value ?>" data-lightbox="roadtrip"><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . 'image.php?src=' . $value . '&size=370x300' ?>"></a>
                            <?php } ?>
                        </div>
                        <div class="slider slider-nav">
                            <?php foreach ($rfq['images'] as $value) { ?>
                                <a href="javascript:void(0)"><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . 'image.php?src=' . $value . '&size=370x300' ?>"></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-xs-12 col-md-4 sub_item">
                <ul class="list-unstyled">
                    <li><?= Yii::t('rfq', 'Tên sản phẩm') ?>: <b><?= $item->getTitle() ?></b></li>
                    <li><?= Yii::t('rfq', 'Danh mục sản phẩm') ?>: <b><a href="<?= \Yii::$app->request->hostInfo ?>/?product_type=<?= $item->getId_category() ?>"><?= $item->getCategory() ?></a></b></li>
                    <li><?= Yii::t('rfq', 'Thời gian: {0} đến {1}',['<b>'.$item->getDatestart().'</b>','<b>'.$item->getDateend().'</b>']) ?> </li>
                </ul>
            </div>
            <div class="col-xs-12 col-md-4 sub_item">
                <ul class="list-unstyled">
                    <li><?= Yii::t('rfq', 'Số lượng') ?>:  <b><?= $item->getQuantity() ?></b></li>
                    <li><a href="/manager/offer/<?= $item->getId() ?>" class="badge badge-success badge-pill"><?= $item->countOffer() ?> <?= Yii::t('rfq', 'Báo giá') ?></a></li>

                </ul>
            </div>
            <div class="col-xs-12 col-md-2">
                <div class="pull-right action-offer">
                    <p><strong><?= Constant::STATUS_SHOW_RFQ[$rfq['status']] ?></strong></p>
                    <?php if ($rfq['status'] != Constant::STATUS_FINISH && $rfq['status'] != Constant::STATUS_STOP) { ?>
                        <?= Html::a(Yii::t('rfq', 'Cập nhật'), ['manager/update', 'id' => (string) $rfq['_id']]) ?> | 
                        <?=
                        Html::a(Yii::t('rfq', 'Dừng tìm hàng'), ['rfq/stop', 'id' => (string) $rfq['_id']], [
                            'data-confirm' => Yii::t('rfq', 'Bạn có muốn dừng tìm kiếm hàng ?'),
                            'data-method' => 'post',
                        ])
                        ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <br>
    <h3><?= Yii::t('rfq', 'Nhà cung cấp đã báo giá') ?></h3>
    <p style="margin-top: 10px"><?= Yii::t('rfq', 'Hãy liên hệ trực tiếp với nhà cung cấp để trao đổi thêm về yêu cầu của bạn.') ?></p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'emptyText' => Yii::t('rfq', 'Chưa có báo giá nào !'),
        'tableOptions' => ['class' => 'table table-bordered table_responsive table-striped'],
        'columns' => [
            [
                'attribute' => Yii::t('rfq', 'Tên nhà cung cấp'),
                'format' => 'raw',
                'value' => function($data) {
                    return data(Yii::t('rfq', 'Tên nhà cung cấp'), '<a target="_blank" href="' . Yii::$app->setting->get('siteurl') . '/nha-cung-cap/' . $data['actor']['username'] . '-' . $data['actor']['id'] . '">' . (!empty($data['actor']['garden_name']) ? $data['actor']['garden_name'] : $data['actor']['fullname']) . '</a>');
                },
            ],
            [
                'attribute' => Yii::t('rfq', 'Thông tin liên hệ'),
                'format' => 'raw',
                'value' => function($data) {
                    return data(Yii::t('rfq', 'Thông tin liên hệ'), '<a target="_blank" href="tel:' . $data['actor']['phone'] . '">' . $data['actor']['phone'] . '</a>');
                },
            ],
            [
                'attribute' => Yii::t('rfq', 'Giá cung cấp') . ' (vnđ)',
                'format' => 'raw',
                'value' => function($data) {
                    return data(Yii::t('rfq', 'Giá cung cấp') . ' (vnđ)', Constant::price($data['price']) . ' vnđ');
                },
            ],
            [
                'attribute' => Yii::t('rfq', 'Mô tả'),
                'format' => 'raw',
                'value' => function($data) {
                    return data(Yii::t('rfq', 'Mô tả'), !empty($data['description']) ? $data['description'] : '<small>(' . Yii::t('rfq', 'Không có mô tả !') . ')<small>');
                },
            ],
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{view}{delete}{update}',
//                'buttons' => [
//                    'view' => function ($url, $model) {
//                        return '<p class="status-request">' . Constant::STATUS_SHOW_APPLY[$model['status']] . '</p>';
//                    },
//                    'delete' => function ($url, $model) {
//                        if ($model['status'] == Constant::STATUS_PENDING) {
//                            return Html::a(Yii::t('rfq', 'agree'), '/manager/complete/' . (string) $model['_id'], [
//                                        'title' => Yii::t('rfq', 'agree'),
//                                        'data-confirm' => Yii::t('rfq', 'rfq_offer_agree_confirm'),
//                                        'data-method' => 'post',
//                            ]);
//                        }
//                    },
//                    'update' => function ($url, $model) {
//                        if ($model['status'] == Constant::STATUS_PENDING) {
//                            return " | " . Html::a(Yii::t('rfq', 'deny'), '/manager/deny/' . (string) $model['_id'], [
//                                        'title' => Yii::t('rfq', 'deny'),
//                                        'data-confirm' => Yii::t('rfq', 'rfq_offer_deny_confirm'),
//                                        'data-method' => 'post',
//                            ]);
//                        }
//                    }
//                ],
//                'headerOptions' => ['width' => 150]
//            ],
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

    $('.slider-single').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        asNavFor: '.slider-single',
        dots: true,
        centerMode: true,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            }

        ],
    });

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
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