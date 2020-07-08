<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use common\components\Constant;

$this->title = \Yii::t('frontend', 'Giỏ hàng');
$this->params['breadcrumbs'][] = $this->title;
$province = Yii::$app->province;
$array = [];
foreach ($cart->getItems() as $key => $value) {
    $item = $cart->getItem($key);
    $array[$value->getProduct()['owner']['id']][] = $item;
}
?>
<div class="container container-mobile">
    <h4 class="main-title"><?= Html::encode($this->title) ?> (<?= $cart->getTotalCount() ?>)</h4>

    <div class="row" style="min-height:500px">
        <?php
        $form = ActiveForm::begin();
        if (!empty($cart->getItems())) {
            ?>
            <div class="col-md-9">
                <?php
                $stt = 1;
                $price = 0;
                $quantity = 0;
                ?>
                <?php
                foreach ($array as $k => $product) {
                    $seller = $cart->getSeller($k);
                    ?>
                    <div class="table-responsive" style="background-color: #fff; margin-bottom: 20px">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" colspan="4"><?= Yii::t('user', $seller['garden_name']) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sum = 0;
                                foreach ($product as $key => $value) {
                                    $price += $value->getQuantity() * $value->getPrice();
                                    $quantity += $value->getQuantity();
                                    ?>
                                    <tr class="<?= ($sum % 2 == 1) ? "color-table" : "" ?>">
                                        <td>
                                            <div class="right" style=" overflow: hidden">
                                                <a href="<?= $value->getProduct()['url'] ?>">
                                                    <img class="" style="border-radius: 5px;float:left; margin-right: 10px" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value->getProduct()['image'] ?>&size=50x50">
                                                    <div>

                                                        <?= Yii::t('product', $value->getProduct()['title']) ?> <?= $value->getType() > 0 ? '(' . \Yii::t('frontend', 'Loại') . ' ' . $value->getType() . ')' : "" ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="left"><?= \Yii::t('frontend', 'Đơn giá') ?></div>
                                            <div class="right total"  id="price-<?= $value->getId() ?>">
                                                <?= number_format($value->getPrice(), 0, '', '.') ?> ₫
                                            </div>
                                        </td>
                                        <td>
                                            <div class="left"><?= \Yii::t('frontend', 'Số lượng') ?></div>
                                            <div class="right">
                                                <ul class="quanlity choosenumđber quantity_<?= $value->getId() ?>">

                                                    <li><a href="javascript:void(0)" class="abate <?= $value->getQuantity() > 1 ? "" : "none" ?>" data-type="abate" data-id="<?= $value->getId() ?>"><i class="fa fa-minus"></i></a></li>
                                                    <li><span style="padding:0; border: 0"><input id="number-<?= $value->getId() ?>" type="text" style="width: 55px; text-align: center; font-size: 15px;" data-id="<?= $value->getId() ?>" data-value="<?= $value->getQuantity() ?>" value="<?= $value->getQuantity() ?>" class="number"></span></li>
                                                    <li><a href="javascript:void(0)" class="augment" data-type="augment" data-id="<?= $value->getId() ?>"><i class="fa fa-plus"></i></a></li>

                                                </ul>
                                                <p id="msg-<?= $value->getId() ?>" style="color:red; clear: both;"><small></small></p>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="right">
                                                <a style="color: red;" href="/cart/remove/<?= $value->getId() ?>"><?= \Yii::t('frontend', 'Xóa') ?></a>
                                            </div>
                                        </td>
                                    </tr>


                                    <?php
                                    $sum++;
                                }
                                ?>


                            </tbody>

                        </table>
                    </div>
                    <?php
                }
                ?>


            </div>
            <div class="col-sm-3">
                <div class="panel panel-default" style="border:0; border-radius: 0">
                    <div class="panel-body">
                        <div class="total">
                            <?= \Yii::t('frontend', 'Tạm tính') ?>: <strong class="pull-right"><?= number_format($price, 0, '', '.') ?> ₫</strong> 
                        </div>
                        <div class="total" style="border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px; font-size: 18px; font-weight: 300">
                            <?= \Yii::t('frontend', 'Thành tiền') ?>: <strong class="pull-right text-danger" style=" font-weight: 500"><?= number_format($price, 0, '', '.') ?> ₫</strong> 
                        </div>
                    </div>
                </div>
                <div class="btn-ship" style="padding: 0 10px; margin-bottom: 20px;">
                    <?php
                    if (Yii::$app->user->isGuest) {
                        ?>
                        <a href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->urlManager->createAbsoluteUrl(['/cart/checkout'])) ?>" class="btn btn-success" style="padding: 6px 24px; width: 100%"><?= \Yii::t('frontend', 'Tiến hành đặt hàng') ?></a>
                        <?php
                    } else {
                        ?>
                        <input type="button" id="shipping" class="btn btn-success" style="padding: 6px 24px; width: 100%;" value="<?= \Yii::t('frontend', 'Tiến hành đặt hàng') ?>">
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div style="text-align: center; margin: 50px auto">
                <img src="/template/images/cart.png" style="width: 250px">
                <p><?= \Yii::t('frontend', 'Bạn không có sản phẩm nào trong giỏ hàng') ?></p>
            </div>
            <?php
        }
        ?>
        <?php
        ActiveForm::end();
        ?>
    </div>
</div>
<?php ob_start(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").on("click", "#shipping-submit", function () {
            $("#modal-order").modal('hide');
            $("#formShipping").submit();
        });
    });
    $('.select2-select').select2({});

    $("#invoice-province").on("change", function (event, state) {
        $.ajax({
            type: "GET",
            url: "/ajax/district/" + $("#invoice-province option:selected").val(),
            success: function (data) {
                var option = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value=' + data[i]._id + '>' + data[i].name + '</option>';
                    }
                    $("#invoice-district").html(option);
                    var option_ward = '';
                    if (data[0].ward.length > 0) {
                        for (var i = 0; i < data[0].ward.length; i++) {
                            option_ward += '<option value=' + data[0].ward[i].slug + '>' + data[0].ward[i].name + '</option>';
                        }
                    }
                } else {
                    option_ward += '<option value>Phường/Xã</option>';
                    option += '<option value>Quận/Huyện</option>';
                }
                $("#invoice-ward").html(option_ward);
            },
        });
    });
    $("#invoice-district").on("change", function (event, state) {
        $.ajax({
            type: "GET",
            url: "/ajax/ward/" + $("#invoice-district option:selected").val(),
            success: function (data) {
                var option = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value=' + data[i].slug + '>' + data[i].name + '</option>';
                    }
                } else {
                    option += '<option value>Phường/Xã</option>';
                }
                $("#invoice-ward").html(option);
            },
        });
    });
    $('.quantity').on('keyup keypress blur change', function (e) {
        var q = parseInt($(this).attr('max'));
        var val = parseInt($(this).val());
        if (val > q) {
            $(this).val(q);
            return false;
        }

    });
    $('.number').on('change', function (e) {
        var id = $(this).attr("data-id");
        var val = ($(this).val());
        $.ajax({
            type: "POST",
            url: "/cart/changequantity",
            data: {id: id, quantity: val},
            success: function (data) {
                if (data.error != "") {
                    $("#msg-" + id + " small").html(data.error);
                } else {
                    $("#msg-" + id + " small").html("");
                    $("#number-" + id).val(data.quantity);
                    $(".header-cart .circle").html(data.count);
                    $(".header-cart .price-value").html(data.total);
                    $(".total strong").html(data.total + ' ₫');
                }
            },
        });

    })
    $(".abate, .augment").on("click", function (event, state) {
        var type = $(this).attr("data-type");
        var id = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "/cart/number",
            data: {id: id, type: type},
            success: function (data) {
                if (data.error != "") {
                    $("#msg-" + id + " small").html(data.error);
                } else {
                    $("#msg-" + id + " small").html("");
                    if (data.quantity > 1) {
                        $(".quantity_" + id + " .abate").removeClass("none");
                    } else {
                        $(".quantity_" + id + " .abate").addClass("none");
                    }
                    $("#number-" + id).val(data.quantity);
                    $(".header-cart .circle").html(data.count);
                    $(".header-cart .price-value").html(data.total);
                    $(".total span").html(data.total);
                    $("#price-" + id).html(data.price + ' đ');
                    $(".total strong").html(data.total + ' ₫');
                }
            },
        });
    });

    $("body").on("click", "#shipping", function () {
        $.get('/cart/shipping', function (data) {
            $('#modal-order').modal('show').find('#modalContent').html(data)
        });

    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>' . \Yii::t('frontend', 'Thông tin giao hàng') . '</span>',
    'footer' => '<button id="shipping-submit" type="button" class="btn btn-success btn-transport">' . \Yii::t('frontend', 'Tiến hành đặt hàng') . '</button>',
    'id' => 'modal-order',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div id='modalContent'>

</div>
<?php
yii\bootstrap\Modal::end();
?>
