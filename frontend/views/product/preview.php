<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;
use common\components\Constant;
use common\widgets\Alert;

$this->title = $model->title;

$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->urlManager->createAbsoluteUrl([$model->slug . '-' . $model->id])]);
$this->registerMetaTag(['property' => 'og:image', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/' . $model->images[0]]);

$this->params['breadcrumbs'][] = ['label' => $model->category['title'], 'url' => ['/filter?category=' . $model->category['id']]];
$this->params['breadcrumbs'][] = ['label' => $model->product_type['title'], 'url' => ['/filter?type=' . $model->product_type['id']]];
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
                                            <a href="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=350x350" rel="group">
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
                                        <div class="item">
                                            <a href="javascript:void(0)"><img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=80x80" alt="<?= $model->title ?>"></a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="text-center" style="margin-top:10px">
                                    <a href="javascript:void(0)" data-id="<?= $model->id ?>" class="report"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Báo cáo</a>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-7 col-right">

                            <?php $form = ActiveForm::begin(['id' => 'cart-form', 'options' => ['class' => 'cart form-horizontal']]); ?>
                            <h1 class="product-title"><?= $model->title ?></h1>



                            <div class="product-price" style="display:none">
                                <span class="orange"></span> / <span class="unit"><?= $model->unit ?></span> 
                            </div>
                            <?php
                            if ($model->price_type == 1) {
                                echo $this->render('price/default', ['model' => $model]);
                                $quantity_purchase = $model->quantity_purchase;
                            } elseif ($model->price_type == 2) {
                                echo $this->render('price/approx', ['model' => $model]);
                                $quantity_purchase = $model->quantity_purchase;
                            } else {
                                echo $this->render('price/classify', ['model' => $model, 'count' => $count]);
                                $quantity_purchase = array_sum(array_column($model->classify, 'quantity_purchase'));
                            }
                            if ($seller->getPayment()) {
                                ?>
                                <div class="transport">
                                    <small><b>Hình thức thanh toán</b>: <?= $seller->getPayment() ?></small>
                                </div>
                                <?php
                            }
                            ?>


                            <?php ActiveForm::end(); ?>
                            <!--<div class="label-download-app"><a target="_blank" href="#"><span class="hot-tag">HOT</span> <strong>Tải ứng dụng Mua Sỉ</strong> để nhận được giá sỉ tốt hơn mỗi ngày!</a></div>-->
                            <div class="count-product-buy"> 

                                <?php
                                if ($model->countdown) {
                                    ob_start();
                                    $uni = uniqid();
                                    ?>
                                    <script type="text/javascript">
                                        $("#countdown-<?= $uni ?>").countdown("<?= $model->time_end ?> 23:59:59", function (event) {
                                            $(this).html(event.strftime('<i class="fa fa-clock-o" aria-hidden="true"></i> Còn %D ngày %H:%M:%S'));
                                        });
                                    </script>
                                    <?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
                                    <div class="count-time" id="countdown-<?= $uni ?>"></div>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="sec-pro">
                    <h3 class="sec-title">Mô tả sản phẩm</h3>
                    <div class="sec-content">
                        <?= nl2br($model->description) ?>
                    </div>
                </div>
                <div class="sec-pro">
                    <h3 class="sec-title">Giới thiệu sản phẩm</h3>
                    <div class="sec-content">
                        <?= nl2br($model->content) ?>
                    </div>
                </div>

            </div>


            <div id="sidebar" class="col-md-3">
                <div class="sb-section detail-company">
                    <div class="sb-content">
                        <h4 class="sb-sub">Được cung cấp bởi</h4>
                        <p class="sale-place"> <a href="<?= $seller->getUrl() ?>"><?= $seller->getGardenName() ?></a></p>
                        <div class="rating">
                            <?php
                            if ($seller->getCountReview() > 0) {
                                ?>
                                <div class="star">
                                    <div class="empty-stars"></div>
                                    <div class="full-stars" style="width:<?= $seller->getTotalReview() * 20 ?>%"> </div>

                                </div>
                                <small><a class="count-review" href="<?= $seller->getUrl() ?>?type=review">( <?= $seller->getCountReview() ?> đánh giá )</a></small>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="line"></div>
                        <ul class="row list-info">
                            <li class="col-xs-5">Ngày tham gia </li>
                            <li class="col-xs-7"><?= $seller->getCreated() ?></li>
                            <div style="clear: both;"></div>
                            <li class="col-xs-5"> Giao dịch</li>
                            <li class="col-xs-7 has-color">Đã giao dịch <strong><?= $seller->getCountDeal() ?></strong> lần</li>
                            <li class="col-xs-5">Tỷ lệ giao dịch</li>
                            <li class="col-xs-7 has-color"><strong><?= $seller->getPercentageDeal() ?>%</strong> tỉ lệ xử lý đơn hàng</li>
                            <div style="clear: both;"></div>
                            <li class="col-xs-5">Địa chỉ</li>
                            <li class="col-xs-7"><?= $seller->getAddress() ?></li>
                            <?php
                            if ($seller->getTrademark()) {
                                ?>
                                <li class="col-xs-5">Thương hiệu</li>
                                <li class="col-xs-7"><?= $seller->getTrademark() ?></li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($seller->getCertificate()) {
                                ?>
                                <li class="col-xs-5">Tiêu chuẩn</li>
                                <li class="col-xs-7"><?= $seller->getCertificate() ?></li>
                                <?php
                            }
                            ?>
                            <li class="col-xs-5">Quy mô</li>
                            <li class="col-xs-7"><?= $seller->getAcreage() ?></li>
                            <li class="col-xs-5">Sản lượng</li>
                            <li class="col-xs-7"><?= $seller->get0utputProvided() ?></li>
                            <?php
                            if ($seller->getMoney()) {
                                echo '<li class="col-xs-12">' . $seller->getMoney() . '</li>';
                            }
                            ?>

                        </ul>
                    </div>
                    <a href="/nha-vuon/<?= $seller->getUsername() ?>" class="view-company">Xem thông tin nhà cung cấp</a>
                </div>
                <?php
                if ($product_recent) {
                    ?>
                    <div class="sb-section detail-company">
                        <div class="sb-content">
                            <!--<a href="#"><img src="images/banner-adv.jpg" alt="Banner"></a>-->
                            <h5>Sản phẩm cùng loại</h5>
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
                            <h5>Đã mua sản phẩm này</h5>
                            <ul class="ul-list">
                                <?php
                                foreach ($buyer as $value) {
                                    ?>
                                    <li>
                                        <a href="/user/view/<?= $value['buyer']['id'] ?>"><?= $value['buyer']['name'] ?></a>
                                        <br><small>Ngày mua hàng: <?= date('d/m/Y H:i:s', $value['created_at']) ?></small>
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
            <h3>Sản phẩm khác</h3>
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
    var unit = "<?= $model->unit ?>";
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
            $('#quantity-error').html('Số lượng mua tối thiểu là ' + min + ' ' + unit);
        }
        if (val > max) {
            $('#quantity-error').html('Số lượng mua tối đa là ' + max + ' ' + unit);
        }
    });
    $('.quantity').on('click', '.fa-plus', function (e) {
        e.preventDefault();
        $('#quantity-error').html('');
        var max = parseInt($("#cart-quantity").attr('max'));
        var number = parseInt($('#cart-quantity').val());
        if (number >= max) {
            $('#cart-quantity').val(max);
            $('#quantity-error').html('Số lượng mua tối đa là ' + max + ' ' + unit);
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
            $('#quantity-error').html('Số lượng mua tối thiểu là ' + min + ' ' + unit);
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
                    $(".cart-msg").html("Bạn thêm giỏ hàng thành công");
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
        if ((quantity < min) || (quantity > max)) {
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?= $url ?>",
            data: {id: id, quantity: quantity, kind: kind, type: 'addcart'},
            success: function (data) {
                if (data.error) {
                    $('#quantity-error').html(data.error);
                } else {
                    $(".header-cart .circle").html(data.count);
                    $('.addcart small').html('(Đã thêm)');
                }
            },
        });
    });

    $('.count-review').on("click", function (e) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".sec-review").offset().top
        }, 2000);
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


</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'id' => 'modal-report',
    'header' => '<strong>Giúp chúng tôi hiểu điều gì đang xảy ra</strong>',
    'size' => 'modal-sm',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Huỷ</button> <button type="button" class="btn btn-primary btn-report">Gửi báo cáo</button>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContentReport'><div style=\"text-align:center\"><img src=\"/template/images/loading.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>