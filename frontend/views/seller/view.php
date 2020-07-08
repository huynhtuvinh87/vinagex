<?php

use yii\widgets\ListView;
use common\components\Constant;

$this->title = \Yii::t('frontend', $model->garden_name);
\Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => trim(Constant::excerpt($model->about, 155)),
]);
\Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => 'rau, củ, quả, trái cây'
]);
\Yii::$app->view->registerMetaTag([
    'property' => "og:description",
    'content' => trim(Constant::excerpt($model->about, 155)),
]);
$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->urlManager->createAbsoluteUrl(['nha-cung-cap/' . $model->username])]);
$this->registerMetaTag(['property' => 'og:image', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/' . $model->images[0]]);
$this->registerMetaTag(['property' => 'og:image:secure_url', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/' . $model->images[0]]);
$this->registerMetaTag(['property' => 'og:image:alt', 'content' => $this->title]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container container-mobile">
    <?= $this->render('menuMobile', ['model' => $model]) ?>
    <div id="main-content" class="company-content">
        <div id="content" class="grid-main">
            <div class="main-wrap">
                <div class="top-company">
                    <h3 class="title" title="<?= Yii::t('data', $model->garden_name) ?>">
                        <span><?= Yii::t('data', $model->garden_name) ?></span>
                        <?php if ($model->active['garden_name'] == 1) { ?>
                            <span class="assesment-info">
                                <a href="#" target="_blank" class="assesment-icon"><i class="assesment-icon-i icon-sa"></i></a>
                            </span>
                        <?php } ?>
                        <?php
                        if (Yii::$app->user->isGuest) {
                            ?>
                            <a href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl') . '/nha-cung-cap/' . $model->username) ?>"><img src="/template/svg/like.svg"></a>
                            <?php
                        } else {
                            ?>
                            <a href="javascript:void(0)" class="favorite"><img src="/template/svg/<?= $model->getLike() ? "like-active" : "like" ?>.svg"></a>
                            <?php
                        }
                        ?>
                    </h3>

                    <div class="option">
                        <!--<a href="#" class="chat-now">!</a>-->
                        <!--<a href="#" class="supplier-feedback"><i class="fa fa-envelope" aria-hidden="true"></i>Liên hệ nhà cung cấp</a>-->
                        <?= $model->active['insurance_money'] == 1 ? "<a href='#' class=''>" . \Yii::t('common', 'Đã đóng bảo hiểm: ') . number_format($model->insurance_money) . " ₫</a>" : "" ?>
                    </div>

                </div>
                <div class="company-detail">
                    <div class="row">
                        <div class="col-md-3 images-seller">
                            <?php
                            if (!empty($model->images)) {
                                ?>
                                <div class="slide-company">
                                    <div class="slider slider-for">

                                        <?php foreach ($model->images as $key => $value) { ?>
                                            <div class="item">
                                                <a href="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . $value; ?>" rel="group" data-lightbox="roadtrip">
                                                    <img  class="lazyload <?= $key == 0 ? "" : "set-img" ?>" data-src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=400x400"  src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=images/default.gif&size=350x350">
                                                </a>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <div class="slider slider-nav">
                                        <?php foreach ($model->images as $key => $value) { ?>
                                            <div class="item">
                                                <span><img  class="lazyload <?= $key == 0 ? "" : "set-img" ?>" data-src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=50x50"  src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=images/default.gif&size=50x50" alt="img"></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-9 company-info">
                            <div class="info-content">
                                <table class="content-table">
                                    <tbody>
                                        <tr>
                                            <td class="col-title"><?= \Yii::t('common', 'Họ và tên') ?>:</td>
                                            <td class="col-value"><?= $model->fullname ?></td>
                                            <td class="check-verify"></td>
                                        </tr>
                                        <tr>
                                            <td class="col-title"><?= \Yii::t('common', 'Số điện thoại') ?>:</td>
                                            <td class="col-value"><?= Yii::$app->user->isGuest ? substr($model->phone, 0, 3) . '********' : $model->phone; ?></td>
                                            <?php if ($model->active['phone'] == 1) { ?>
                                                <td class="check-verify"><i class="fa fa-check" aria-hidden="true"></i><span><?= \Yii::t('common', 'Xác thực') ?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td class="col-title"><?= \Yii::t('common', 'Địa chỉ') ?>:</td>
                                            <td class="col-value"><?= $model->address ?>, <?= $model->ward['name'] ?>, <?= $model->district['name'] ?>, <?= $model->province['name'] ?></td>
                                            <?php if ($model->active['address'] == 1) { ?>
                                                <td class="check-verify"><i class="fa fa-check" aria-hidden="true"></i><span><?= \Yii::t('common', 'Xác thực') ?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <?php if (!empty($model->trademark)) { ?>
                                            <tr>
                                                <td class="col-title"><?= \Yii::t('common', 'Thương hiệu') ?>:</td>
                                                <td class="col-value"><?= \Yii::t('frontend', $model->trademark) ?></td>
                                                <?php if ($model->active['trademark'] == 1) { ?>
                                                    <td class="check-verify"><i class="fa fa-check" aria-hidden="true"></i><span><?= \Yii::t('common', 'Xác thực') ?></span></td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>

                                        <?php
                                        if (count($model->certificate) > 0) {
                                            $cer = [];
                                            foreach ($model->certificate as $value) {
                                                if ($value['active'] == 1) {
                                                    $cer[] = Yii::t('data', 'certification_' . $value['id']);
                                                }
                                            }
                                            if (count($cer) > 0) {
                                                ?>
                                                <tr>
                                                    <td class="col-title"><?= \Yii::t('common', 'Chứng nhận') ?>:</td>
                                                    <td class="col-value">
                                                        <?php
                                                        echo implode(', ', $cer);
                                                        ?>
                                                    </td>
                                                    <td class="check-verify"><i class="fa fa-check"></i> <span><?= \Yii::t('common', 'Xác thực') ?></span></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>

                                        <tr>
                                            <td class="col-title"><?= \Yii::t('common', 'Sản phẩm cung cấp') ?>:</td>
                                            <td class="col-value"><?php
                                                $category = [];
                                                if ($model['category']) {
                                                    foreach ($model['category'] as $key => $value) {
                                                        $category[] = '<a href="/filter?category=' . $value['category_id'] . '&type%5B%5D=' . $value['id'] . '">' . Yii::t('data', 'sub_category_' . $value['id']) . '</a>';
                                                    }
                                                    echo implode(',', $category);
                                                }
                                                ?>
                                            </td>
                                            <?php if ($model->active['category'] == 1) { ?>
                                                <td class="check-verify"><i class="fa fa-check" aria-hidden="true"></i> <span><?= \Yii::t('common', 'Xác thực') ?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td class="col-title"><?= \Yii::t('common', 'Sản lượng cung cấp') ?>:</td>
                                            <td class="col-value"><?= $model->output_provided . ' ' . Yii::t('common', $model->output_provided_unit) ?>/<?= Yii::t('common', 'Năm') ?></td>
                                            <?php if ($model->active['output_provided'] == 1) { ?>
                                                <td class="check-verify"><i class="fa fa-check" aria-hidden="true"></i> <span><?= \Yii::t('common', 'Xác thực') ?></span></td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <td class="col-title"><?= \Yii::t('common', 'Diện tích') ?>:</td>
                                            <td class="col-value"><?= $model->acreage ?> ha</td>
                                            <?php if ($model->active['acreage'] == 1) { ?>
                                                <td class="check-verify"><i class="fa fa-check" aria-hidden="true"></i> <span><?= \Yii::t('common', 'Xác thực') ?></span></td>
                                            <?php } ?>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="company-section">
                        <h3 class="comp-title"><?= \Yii::t('common', 'Giới thiệu') ?></h3>
                        <div class="comp-content">
                            <div class="comp-text">
                                <?= \Yii::t('data', $model->about) ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (count($model->certificate) > 0) {
                        foreach ($model->certificate as $key => $value) {
                            $active[$value['name']] = $value['active'];
                        }
                        if (in_array(1, $active)) {
                            ?>
                            <div class="company-section">
                                <h3 class="comp-title"><?= \Yii::t('common', 'Chứng nhận') ?></h3>
                                <div class="comp-content">
                                    <table class="table table-bordered table-customize table-responsive">
                                        <thead>
                                            <tr>
                                                <th class="col-title"><?= \Yii::t('common', 'Hình ảnh') ?></th>
                                                <th class="col-value"><?= \Yii::t('common', 'Tên chứng nhận') ?></th>
                                                <th class="col-value"><?= \Yii::t('common', 'Nơi cấp') ?></th>
                                                <th class="col-value"><?= \Yii::t('common', 'Ngày cấp') ?></th>
                                                <th class="check-verify"><?= \Yii::t('common', 'Xác thực') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($model->certificate as $value) {
                                                if ($value['image'] && $value['date_begin'] && $value['date_end']) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= \Yii::t('common', 'Hình ảnh') ?>">
                                                            <?php if ($value['active'] == 1) { ?>
                                                                <a href="javascript:void(0)" class="image_zoom" data-src="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . $value['image'] ?>" data-title="<?= Yii::t('data', 'certification_' . $value['id']) ?>">
                                                                    <img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . $value['image'] ?>" width="50">
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                        <td data-title="<?= \Yii::t('common', 'Tên chứng nhận') ?>"><?= Yii::t('data', $value['name']) ?></td>
                                                        <td data-title="<?= \Yii::t('common', 'Nơi cấp') ?>"><?= $value['date_begin'] ?></td>
                                                        <td data-title="<?= \Yii::t('common', 'Ngày cấp') ?>"><?= $value['date_end'] ?></td>
                                                        <td data-title="<?= \Yii::t('common', 'Xác thực') ?>" >
                                                            <?php if ($value['active'] == 1) { ?>
                                                                <span style="color:#52af50"><i class="fa fa-check" aria-hidden="true"></i> <?= \Yii::t('common', 'Xác thực') ?></span>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <span class="text-danger"><i class="fa fa-remove" aria-hidden="true"></i> <?= \Yii::t('common', 'Chưa xác thực') ?></span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>                
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
        <?= $this->render('sidebar', ['model' => $model]) ?>
    </div>
    <div class="more-pro">
        <h3><?= \Yii::t('common', 'Sản phẩm') ?></h3>
        <div class="wrap-product">
            <?=
            ListView::widget([
                'dataProvider' => $dataProviderProduct,
                'options' => [
                    'tag' => 'div',
                    'id' => 'list-wrapper',
                    'class' => "list-product row gird gird-5"
                ],
                'emptyText' => \Yii::t('common', 'Không có sản phẩm nào'),
                'itemOptions' => ['class' => 'col-sm-3 col-lg-3 col'],
                'layout' => "{items}",
                'itemView' => '/product/_item',
            ]);
            ?>
        </div>
        <?php
        if ($dataProviderProduct->getTotalCount() > 0) {
            ?>
            <p class="text-center" style="margin-top: 15px;"><a href="/nha-vuon/<?= $model->username ?>?type=product" class="btn btn-success"><?= \Yii::t('common', 'Xem thêm') ?></a></p>
            <?php
        }
        ?>
    </div>
</div>
<?php ob_start(); ?>
<script type="text/javascript">
<?php if (!empty($wishlist)) { ?>
        $(".favorite").one("click", removeFavorite);
<?php } else { ?>
        $(".favorite").one("click", addFavorite);
<?php } ?>

    function addFavorite() {
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["wishlist/seller"]); ?>',
            type: 'POST',
            data: 'seller_id=<?= $model->id ?>',
            success: function (data) {
                $(".favorite img").attr('src', '/template/svg/like-active.svg');
                return false;
            }
        });

        $(this).one("click", removeFavorite);
    }

    function removeFavorite() {
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["wishlist/remove"]); ?>',
            type: 'POST',
            data: 'seller_id=<?= $model->id ?>',
            success: function (data) {
                $(".favorite img").attr('src', '/template/svg/like.svg');
                return false;
            }
        });
        $(this).one("click", addFavorite);
    }
    setInterval(function () {
        $(".set-img").show();
    }, 1000);
    $('.image_zoom').click(function () {
        var image = $(this).data('src');
        $("#modalHeader span").html($(this).attr("data-title"));
        $('#modal-image').modal('show').find('#modalContent').html('<img src="' + image + '">')
        return false;
    });
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span></span>',
    'id' => 'modal-image',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div id='modalContent' style="text-align: center">

</div>
<?php
yii\bootstrap\Modal::end();
?>