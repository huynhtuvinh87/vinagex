<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;
use common\components\Constant;
use common\widgets\Alert;

$this->title = Yii::t('data', trim($model->title));
\Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => trim(Constant::excerpt($model->content, 155)),
]);
\Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => 'rau, củ, quả, trái cây'
]);
\Yii::$app->view->registerMetaTag([
    'property' => "og:description",
    'content' => trim(Constant::excerpt($model->content, 155)),
]);

$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->urlManager->createAbsoluteUrl([$model->slug . '-' . $model->id])]);
$this->registerMetaTag(['property' => 'og:image', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/' . $model->images[0]]);
$this->registerMetaTag(['property' => 'og:image:secure_url', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/' . $model->images[0]]);
$this->registerMetaTag(['property' => 'og:image:alt', 'content' => $model->title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', trim($model->category['title'])), 'url' => ['/filter?category=' . $model->category['id']]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('data', trim($model->category['title'])), 'url' => ['/filter?type=' . $model->product_type['id']]];
$this->params['breadcrumbs'][] = $this->title;

if ($model->price['min'] == $model->price['max']) {
    $price = Constant::price($model->price['min']);
} else {
    $price = Constant::price($model->price['min']) . ' - ' . Constant::price($model->price['max']);
}
$count = count($model->classify);
$province = Yii::$app->province;
?>
<div class="container container-mobile">
    <div class="main-content product-main">
        <?= Alert::widget() ?>
        <div class="row">
            <div class="col-md-9 product-detail ">
                <div class="product-detail-inner">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="col-left">
                                <div class="slider slider-for"> 
                                    <?php
                                    foreach ($model->images as $key => $value) {
                                        ?>
                                        <div class="item">
                                            <a href="<?= Yii::$app->setting->get('siteurl_cdn') ?>/<?= $value ?>" rel="group" data-lightbox="roadtrip">
                                                <img class="lazyload <?= $key == 0 ? "" : "set-img" ?>" data-src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=375x350" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=images/default.gif&size=375x350" alt="<?= $model->title ?>">
                                            </a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="slider slider-nav">
                                    <?php
                                    foreach ($model->images as $key => $value) {
                                        ?>
                                        <div class="item slider-nav-item">
                                            <a href="javascript:void(0)"><img  class="lazyload set-img" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=80x80" alt="<?= $model->title ?>"></a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if ($model->showProcess()) {
                                    ?>
                                    <div class="text-center" style="margin-top:10px">
                                        <a href="<?= Yii::$app->setting->get('siteurl') ?>/cap-nhat-thong-tin-san-pham/<?= $model->slug ?>-<?= $model->id ?>" class="btn btn-info update_info_product"><?= \Yii::t('frontend', 'Thông tin mới nhất về sản phẩm') ?></a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-7 col-right">

                            <?php $form = ActiveForm::begin(['id' => 'cart-form', 'options' => ['class' => 'cart form-horizontal']]); ?>
                            <h1 class="product-title"><?= Yii::t('product', $model->title) ?></h1>

                            <div class="rating">
                                <?php
                                if ($model->countReview > 0) {
                                    ?>
                                    <div class="star">
                                        <div class="empty-stars"></div>
                                        <div class="full-stars" style="width:<?= $model->getTotalReview() * 20 ?>%"> </div>
                                    </div>

                                    <a class="count-review" href="javascript:void(0)">(<?= $model->countReview ?> <?= \Yii::t('frontend', 'Đánh giá') ?>)</a>

                                    <?php
                                }
                                ?>
                            </div>

                            <div class="product-price" style="display:none">
                                <span class="orange"></span> / <span class="unit"><?= Yii::t('frontend', $model->unit) ?></span> 
                            </div>
                            <?php
                            if ($model->price_type == 1) {
                                echo $this->render('price/default', ['model' => $model]);
                                $quantity_purchase_total = $model->quantity_purchase_total;
                            } elseif ($model->price_type == 2) {
                                echo $this->render('price/approx', ['model' => $model]);
                                $quantity_purchase_total = $model->quantity_purchase_total;
                            } else {
                                echo $this->render('price/classify', ['model' => $model, 'count' => $count]);
                                $quantity_purchase_total = array_sum(array_column($model->classify, 'quantity_purchase_total'));
                            }
                            if ($seller->getPayment()) {
                                ?>
                                <div class="transport">
                                    <small><b><?= \Yii::t('frontend', 'Hình thức thanh toán') ?></b>: <?= $seller->getPayment() ?></small>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="button-group">
                                <div class="item item-buy">
                                    <div class="item-wrap">
                                        <button type="button" name="buynow" class="btn btn-buy buynow"><img src="/template/svg/cart.svg" width="18"> <?= \Yii::t('frontend', 'Mua ngay') ?></button>
                                        <p><?= \Yii::t('frontend', 'Mua trực tiếp từ người bán') ?></p>
                                    </div>
                                </div>
                                <div class="item item-sms">
                                    <div class="item-wrap"> <a href="/message/view/<?= $model->id ?>" class="btn request"><i class="fa fa-envelope" aria-hidden="true"></i> <?= \Yii::t('frontend', 'Nhắn tin') ?></a>
                                        <p><?= \Yii::t('frontend', 'Trao đổi trực tiếp với người bán') ?></p>
                                    </div>
                                </div>
                            </div>

                            <ul class="list-button">
                                <li>
                                    <?php
                                    if (Yii::$app->user->isGuest) {
                                        ?>
                                        <a href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl') . '/' . $model->slug . '-' . $model->id) ?>"><img src="/template/svg/like.svg" width="16"> <?= \Yii::t('frontend', 'Thêm vào yêu thích') ?></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="javascript:void(0)" class="favorite"><?= $model->getLike() ? '<img src="/template/svg/like-active.svg" width="16"> <span>' . \Yii::t('frontend', 'Đã thêm vào yêu thích') . '</span>' : '<img src="/template/svg/like.svg" width="16"> <span>' . \Yii::t('frontend', 'Thêm vào yêu thich') . '</span>' ?></span></a>
                                        <?php
                                    }
                                    ?>
                                    <a href="javascript:void(0)" class="addcart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?= \Yii::t('frontend', 'Thêm vào giỏ hàng') ?> <small></small></a></li>
                                <?php
                                if ($quantity_purchase_total > 0) {
                                    ?>
                                    <li>
                                        <?= $quantity_purchase_total ?> <?= Yii::t('frontend', $model->unit) ?> <?= \Yii::t('frontend', 'đã được mua') ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>

                            <?php ActiveForm::end(); ?>

                            <div class="count-product-buy"> 

                                <?php
                                if ($model->countdown) {
                                    ob_start();
                                    $uni = uniqid();
                                    if (date('d/m/Y', $model->time_begin) == date('d/m/Y', time())) {
                                        echo '<p class="pull-right">Tôi đã có hàng, và sẵn sàng giao.</p>';
                                    } else {
                                        ?>
                                        <script type="text/javascript">
                                            $("#countdown-<?= $uni ?>").countdown("<?= $model->time_begin ?> 23:59:59", function (event) {
                                                $(this).html(event.strftime('<i class="fas fa-exclamation-triangle"></i> Sản phẩn này được đặt lệnh bán trước, sẽ có hàng sau <b>%D ngày %H:%M:%S</b>'));
                                            });
                                        </script>
                                        <?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
                                        <div class="count-time" id="countdown-<?= $uni ?>"></div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="text-right">
                                <a href="javascript:void(0)" data-id="<?= $model->id ?>" class="report"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?= \Yii::t('frontend', 'Báo cáo') ?></a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="sec-pro">
                    <h3 class="sec-title"><?= \Yii::t('frontend', 'Mô tả sản phẩm') ?></h3>
                    <div class="sec-content">
                        <?= nl2br(Yii::t('product', $model->description)) ?>
                    </div>
                </div>
                <div class="sec-pro">
                    <h3 class="sec-title"><?= \Yii::t('frontend', 'Giới thiệu sản phẩm') ?></h3>
                    <div class="sec-content">
                        <?= nl2br(Yii::t('product', $model->content)) ?>
                    </div>
                </div>
                <?= $this->render('review', ['product' => $model, 'dataProviderReview' => $dataProviderReview, 'review']) ?>
                <?php
                echo $this->render('comment', ['product' => $model, 'dataProviderComment' => $dataProviderComment, 'comment' => $comment, 'query' => $query_comment]);
                ?>
            </div>


            <div id="sidebar" class="col-md-3">
                <div class="sb-section detail-company">
                    <div class="sb-content">
                        <h4 class="sb-sub"><?= \Yii::t('frontend', 'Được cung cấp bởi') ?></h4>
                        <p class="sale-place"> <a href="<?= $seller->getUrl() ?>"><?= $seller->getGardenName() ?></a></p>
                        <div class="rating">
                            <?php
                            if ($seller->getCountReview() > 0) {
                                ?>
                                <div class="star">
                                    <div class="empty-stars"></div>
                                    <div class="full-stars" style="width:<?= $seller->getTotalReview() * 20 ?>%"> </div>

                                </div>
                                <small><a href="<?= $seller->getUrl() ?>?type=review">( <?= $seller->getCountReview() . ' ' . \Yii::t('frontend', 'Đánh giá') ?> )</a></small>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        if ($seller->getMoney()) {
                            echo '<a class="money-escrow" href="/dong-phi-bao-hiem"><i class="fas fa-dollar-sign"></i>' . \Yii::t('frontend', 'Đã đóng bảo hiểm: ') . $seller->getMoney() . '</a>';
                        }
                        ?>
                        <div class="line"></div>
                        <ul class="row list-info">
                            <li class="col-xs-5"><?= \Yii::t('frontend', 'Ngày tham gia') ?> </li>
                            <li class="col-xs-7"><?= $seller->getCreated() ?></li>
                            <div style="clear: both;"></div>
                            <li class="col-xs-5"><?= \Yii::t('frontend', 'Giao dịch') ?></li>
                            <li class="col-xs-7 has-color"><?= \Yii::t('frontend', 'Đã giao dịch {0} lần', $seller->getCountDeal()) ?></li>
                            <li class="col-xs-5"><?= \Yii::t('frontend', 'Tỷ lệ giao dịch') ?></li>
                            <li class="col-xs-7 has-color"><?= \Yii::t('frontend', '{0}% xử lý đơn hàng', $seller->getPercentageDeal()) ?></li>
                            <div style="clear: both;"></div>
                            <li class="col-xs-5"><?= \Yii::t('frontend', 'Địa chỉ') ?></li>
                            <li class="col-xs-7"><?= $seller->getAddress() ?></li>
                            <?php
                            if ($seller->getTrademark()) {
                                ?>
                                <li class="col-xs-5"><?= \Yii::t('frontend', 'Thương hiệu') ?></li>
                                <li class="col-xs-7"><?= $seller->getTrademark() ?></li>

                                <?php
                            }
                            if ($seller->getCertificate()) {
                                ?>
                                <li class="col-xs-5"><?= \Yii::t('frontend', 'Tiêu chuẩn') ?></li>
                                <li class="col-xs-7"><?= $seller->getCertificate() ?></li>
                                <?php
                            }
                            ?>
                            <li class="col-xs-5"><?= \Yii::t('frontend', 'Quy mô') ?></li>
                            <li class="col-xs-7"><?= $seller->getAcreage() ?></li>
                            <li class="col-xs-5"><?= \Yii::t('frontend', 'Sản lượng') ?></li>
                            <li class="col-xs-7"><?= $seller->get0utputProvided() ?></li>
                        </ul>
                    </div>
                    <a href="<?= $seller->getUrl() ?>" class="view-company"><?= \Yii::t('frontend', 'Xem thông tin nhà cung cấp') ?></a>
                </div>
                <?php
                if ($product_recent) {
                    ?>
                    <div class="sb-section detail-company">
                        <div class="sb-content">
                            <!--<a href="#"><img src="images/banner-adv.jpg" alt="Banner"></a>-->
                            <h5><?= Yii::t('frontend', 'Sản phẩm cùng loại') ?></h5>
                            <div class="list-feature">
                                <?php
                                foreach ($product_recent as $value) {
                                    echo $this->render('/product/_list', ['model' => $value]);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
                if ($buyer) {
                    ?>
                    <div class="sb-section detail-company">
                        <div class="sb-content">
                            <!--<a href="#"><img src="images/banner-adv.jpg" alt="Banner"></a>-->
                            <h5><?= \Yii::t('frontend', 'Đã mua sản phẩm này') ?></h5>
                            <ul class="ul-list">
                                <?php
                                foreach ($buyer as $value) {
                                    ?>
                                    <li>
                                        <a href="/user/view/<?= $value['buyer']['id'] ?>"><?= $value['buyer']['name'] ?></a>
                                        <br><small><?= \Yii::t('frontend', 'Ngày mua hàng') ?>: <?= date('d/m/Y H:i:s', $value['created_at']) ?></small>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>


        </div>
        <div class="more-pro">
            <h3><?= \Yii::t('frontend', 'Sản phẩm khác') ?></h3>
            <div class="wrap-product">
                <div class="row list-product gird gird-5">
                    <?php
                    if ($product_seller) {
                        foreach ($product_seller as $value) {
                            ?>
                            <div class="col-sm-3 col">
                                <?= $this->render('/product/_item', ['model' => $value]) ?>
                            </div>
                            <?php
                        }
                    }
                    ?>


                </div>
            </div>
        </div>
    </div>
</div>
<?php ob_start(); ?>
<?php
$url = Yii::$app->urlManager->createUrl(["cart/add"]);
?>
<script type="text/javascript">
    $("#cart-form").keypress(function (event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
    var unit = "<?= Yii::t('frontend', $model->unit) ?>";
    setInterval(function () {
        $(".set-img").show();
    }, 1000);
    $('.select2-select').select2({});
    $("#cart-quantity").on("change", function (event, state) {

        $('#quantity-error').html('');
        var min = parseInt($(this).attr('min'));
        var max = parseInt($(this).attr('max'));
        var val = parseInt($(this).val());
        if (val < min) {
            $('#quantity-error').html('<?= \Yii::t('frontend', 'Số lượng mua tối thiểu là') ?> ' + min + ' ' + unit);
        }
        if (val > max) {
            $('#quantity-error').html('<?= \Yii::t('frontend', 'Số lượng mua tối đa là') ?> ' + max + ' ' + unit);
        }
    });
    $('.quantity').on('click', '.fa-plus', function (e) {
        e.preventDefault();
        $('#quantity-error').html('');
        var max = parseInt($("#cart-quantity").attr('max'));
        var number = parseInt($('#cart-quantity').val());
        if (number >= max) {
            $('#cart-quantity').val(max);
            $('#quantity-error').html('<?= \Yii::t('frontend', 'Số lượng mua tối đa là') ?> ' + max + ' ' + unit);
        } else {
            $('#cart-quantity').val(number + 1);
        }
    });
    $('.quantity').on('click', '.fa-minus', function (e) {
        e.preventDefault();
        $('#quantity-error').html('');
        var val = parseInt($('#cart-quantity').val());
        var min = parseInt($("#cart-quantity").attr('min'));
        if (val > min) {
            $(this).removeClass('disable');
            $('#cart-quantity').val(val - 1);
        } else {
            $('#cart-quantity').val(min);
            $('#quantity-error').html('<?= \Yii::t('frontend', 'Số lượng mua tối thiểu là') ?> ' + min + ' ' + unit);
        }
    });
    $('.dropdown-hover').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });
    $("body").on("click", '.buynow', function (event, state) {
        var id = "<?= $model->id ?>";
        var quantity = parseInt($("#cart-quantity").val());
        var kind = $("#cart-kind").val();
        var min = parseInt($("#cart-quantity").attr("min"));
        var max = parseInt($("#cart-quantity").attr("max"));
        if (isNaN(quantity) || (quantity < min) || (quantity > max)) {
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?= $url ?>",
            data: {id: id, quantity: quantity, kind: kind, type: 'buynow'},
            success: function (data) {
                if (data.error) {
                    $('#quantity-error').html(data.error);
                } else {
                    $(".cart span").html(data.count);
                    $(".cart-msg").html("<?= Yii::t('frontend', 'Bạn thêm giỏ hàng thành công') ?>");
                }
            },
        });
    });
    $(".addcart").on("click", function (event, state) {
        var id = "<?= $model->id ?>";
        var quantity = parseInt($("#cart-quantity").val());
        var kind = parseInt($("#cart-kind").val());
        var min = parseInt($("#cart-quantity").attr("min"));
        var max = parseInt($("#cart-quantity").attr("max"));
        if ((quantity >= min) || (quantity <= max)) {
            $.ajax({
                type: "POST",
                url: "<?= $url ?>",
                data: {id: id, quantity: quantity, kind: kind, type: 'addcart'},
                success: function (data) {
                    if (data.error) {
                        $('#quantity-error').html(data.error);
                    } else {
                        $(".header-cart .circle").html(data.count);
                        var success = '<?= \Yii::t('frontend', 'Đã thêm') ?>';
                        $('.addcart small').html('(' + success + ')');
                    }
                },
            });
        }
    });

    $('.report').click(function () {
        $.get('/product/report/' + $(this).attr('data-id'), function (data) {
            $('#modal-report').modal('show').find('#modalContentReport').html(data);
            $("#modal-report .modal-footer").show()
        });
        return false;
    });

    $("body").on("click", '.btn-report', function (event, state) {
        var data = $('form#report-form').serializeArray();
        $.ajax({
            type: "POST",
            url: "/product/report/<?= $model->id ?>",
            data: $('form#report-form').serialize(),
            success: function (rs) {
                $('#modal-report').modal('hide');
            },
        });
    });

    $(".count-review").click(function () {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".sec-review").offset().top
        }, 2000);
    })

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
<?php if (!empty($wishlist)) { ?>
        $(".favorite").one("click", removeFavorite);
<?php } else { ?>
        $(".favorite").one("click", addFavorite);
<?php } ?>

    function addFavorite() {
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["wishlist/product"]); ?>',
            type: 'POST',
            data: 'product_id=<?= $model->id ?>',
            success: function (data) {
                $(".favorite img").attr('src', '/template/svg/like-active.svg');

                $('.favorite').find('span').html('<?= \Yii::t('frontend', 'Đã thêm vào yêu thích') ?>');
                return false;
            }
        });

        $(this).one("click", removeFavorite);
    }

    function removeFavorite() {

        var id = $(this).data('id');
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["wishlist/remove"]); ?>',
            type: 'POST',
            data: 'product_id=<?= $model->id ?>',
            success: function (data) {
                $(".favorite img").attr('src', '/template/svg/like.svg');
                $('.favorite').find('span').html('<?= \Yii::t('frontend', 'Thêm vào yêu thích') ?>');
                return false;
            }
        });
        $(this).one("click", addFavorite);
    }

    $(function () {
        $(".qty").change(function () {
            var max = parseInt($(this).attr('max'));
            var min = parseInt($(this).attr('min'));
            if ($(this).val() > max)
            {
                $(this).val(max);
            } else if ($(this).val() < min)
            {
                $(this).val(min);
            }
        });
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'id' => 'modal-report',
    'header' => '<strong>' . Yii::t('frontend', 'Giúp chúng tôi hiểu điều gì đang xảy ra') . '</strong>',
    'size' => 'modal-sm',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Huỷ</button> <button type="button" class="btn btn-primary btn-report">Gửi báo cáo</button>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContentReport'><div style=\"text-align:center\"><img src=\"/template/images/loading.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>