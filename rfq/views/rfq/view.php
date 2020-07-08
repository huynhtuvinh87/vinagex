<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use rfq\widgets\SidebarWidget;
use rfq\storage\RfqItem;
use common\components\Constant;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = $this->title;
$item = new RfqItem($rfq);

SidebarWidget::widget();
?>
<?= SidebarWidget::widget() ?>
<div class="container">
    <?=
    Breadcrumbs::widget([
        'homeLink' => ['label' => \Yii::t('common', 'Trang chủ'), 'url' => Yii::$app->homeUrl],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]);
    ?>
    <div class="list_item rfq-view">
        <div class="row">
            <div class="col-sm-4">
                <?php if (!empty($rfq['images'])) { ?>
                    <div class="img-rfq">
                        <div class="slider slider-single">
                            <?php foreach ($rfq['images'] as $key => $value) { ?>
                                <a class="lazyload <?= $key == 0 ? "" : "set-img" ?>" href="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . $value ?>" data-lightbox="roadtrip"><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . 'image.php?src=' . $value . '&size=400x300' ?>"></a>
                            <?php } ?>
                        </div>
                        <div class="slider slider-nav">
                            <?php foreach ($rfq['images'] as $value) { ?>
                                <a class="lazyload" href="javascript:void(0)"><img class="set-img" src="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . 'image.php?src=' . $value . '&size=100x100' ?>"></a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <img src="<?= $item->getImg() ?>">
                <?php } ?>
            </div>
            <div class="col-xs-12 col-sm-8">
                <div class="pull-left">
                    <h2 style="margin-top:0"><?= Yii::t('rfq', $this->title) ?></h2>
                    <ul class="list-unstyled">
                        <li><?= Yii::t('rfq', 'Danh mục') ?>: <b><a href="/site/index?keywords=<?= $item->getCategory() ?>"><?= $item->getCategory() ?></a></b> | <?= Yii::t('common', 'Yêu cầu bởi') ?>: <a target="_blank" href="<?= Yii::$app->setting->get('siteurl') . '/user/view/' . $item->getOwnerId() ?>"><?= $item->getOwnerName() ?></a></li>
                        <li><?= Yii::t('rfq', 'Số lượng') ?>:  <b><?= $item->getQuantity() ?></b></li>
                        <li><?= Yii::t('rfq', 'Ngày mua / hết hạn') ?>: <b><?= Yii::t('rfq', '{start} đến {end}', ['start' => $item->getDatestart(), 'end' => $item->getDateend()]) ?></b></li>
                        <li><?= nl2br(Yii::t('rfq', $item->getContent())) ?></li>
                        <li><a class="badge badge-success badge-pill"><?= $item->countOffer() ?> <?= Yii::t('rfq', 'Báo giá') ?></a></li>
                    </ul>
                </div>
                <div class="pull-right right">
                    <div class="col_sub_left book_now">
                        <?php
                        if (!\Yii::$app->user->isGuest) {
                            if (!$item->checkOwner()) {
                                if ($item->checkOffer()) {
                                    if ($item->checkOfferStatus()) {
                                        ?>
                                        <p><?= Constant::STATUS_SHOW_APPLY[$item->checkOfferStatus()] ?></p>
                                        <?php
                                    } else {
                                        ?>
                                        <p><button class="btn btn-sm btn-primary offer"><?= Yii::t('rfq', 'Đã báo giá') ?></button></p>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <p><button class="btn btn-sm btn-danger offer" data-id="<?= (string) $rfq['_id'] ?>"><?= Yii::t('rfq', 'Báo giá') ?></button></p>
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <a class="btn btn-sm btn-danger" href="<?= Yii::$app->setting->get('siteurl_id') ?>/login?url=<?= Constant::redirect(Constant::domain('rfq')) . '/rfq/view/' . $item->getId() ?>"><?= Yii::t('rfq', 'Báo giá') ?></a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-2">


            </div>
        </div>
    </div>

    <h4 style="margin-top: 20px; text-transform: uppercase"><?= Yii::t('rfq', 'Sản phẩm cùng người mua') ?></h4>
    <?php
    Pjax::begin([
        'id' => 'pjax-rfq_user',
        'enablePushState' => false,
        'timeout' => 100000,
    ]);
    ?>    
    <?=
    ListView::widget([
        'dataProvider' => $rfq_user,
        'options' => [
            'tag' => 'div',
            'id' => 'list-wrapper',
        ],
        'layout' => "{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_item', ['model' => $model]);
        },
    ]);
    ?>
    <?php Pjax::end(); ?>
    <h4 style="margin-top: 20px; text-transform: uppercase"><?= Yii::t('rfq', 'Sản phẩm cùng loại') ?></h4>
    <?php Pjax::begin(['id' => 'pjax-rfq_category']); ?>    
    <?=
    ListView::widget([
        'dataProvider' => $rfq_category,
        'options' => [
            'tag' => 'div',
            'id' => 'list-wrapper',
        ],
        'layout' => "{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_item', ['model' => $model]);
        },
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>

<?php
ob_start();
?>
<script>

    $('.slider-single').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-single',
        dots: true,
        centerMode: true,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
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

    $("body").on("click", ".offer", function () {
        $('#modalHeader').find('span').html('');
        $('#modalHeader').prepend('<span>Báo giá sản phẩm</span>');
        $.get('/rfq/apply/' + $(this).attr("data-id"), function (data) {
            $('#modal-apply').modal('show').find('#modalContent').html(data);
        });
    });
    setInterval(function () {
        $(".set-img").show();
    }, 1000);
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