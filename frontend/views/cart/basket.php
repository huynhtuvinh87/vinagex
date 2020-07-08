<?php

use yii\bootstrap\ActiveForm;

$this->title = 'Giỏ hàng';
$this->params['breadcrumbs'][] = $this->title;
$province = Yii::$app->province;
?>
<div class="container container-mobile">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php
            if (!empty($cart->getItems())) {
                ?>
                <div class="top-cart" style="overflow: hidden; margin-bottom: 10px">
                    <a class="pull-left" href="<?= Yii::$app->setting->get('siteurl') ?>">Tiếp tục mua hàng</a>

                    <a class="pull-right" href="#">Giỏ hàng</a>
                </div>

                <?php
                $form = ActiveForm::begin();
                $stt = 1;
                $price = 0;
                $quantity = 0;
                ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                        foreach ($cart->getItems() as $key => $value) {
                            $price += $value->getQuantity() * $value->getPrice();
                            $quantity += $value->getQuantity();
                            ?>
                            <input type="hidden" name="seller[]" value="<?= $value->getProduct()['owner']['id'] ?>">
                            <div class="row" style="margin-bottom: 20px">
                                <div class="col-xs-3 col-sm-2 col-md-3">
                                    <a href="<?= $value->getProduct()['url'] ?>">
                                        <img class="media-object img-responsive" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value->getProduct()['image'] ?>&size=120x120">
                                    </a>

                                </div>
                                <div class="col-xs-9 col-sm-10 col-md-9">
                                    <div class="media">
                                        <h4 class="media-heading" style="font-weight:300"><a class="title" target="_blank" href="<?= $value->getProduct()['url'] ?>"><?= $value->getProduct()['title'] ?> <?= $value->getType() > 0 ? '(Loại ' . $value->getType() . ')' : "" ?></a>
                                            <small><a class="pull-right" href="/cart/remove/<?= $value->getId() ?>"><?= Yii::t('common', 'Xoá') ?></a></small>
                                        </h4>
                                        <div class="product-price">
                                            <span class="text-danger"><?= number_format($value->getPrice(), 0, '', '.') ?> ₫</span>
                                            <ul class="quanlity pull-right choosenumber quantity_<?= $value->getId() ?>">
                                                <li><a href="javascript:void(0)" class="abate <?= $value->getQuantity() > 1 ? "" : "none" ?>" data-type="abate" data-id="<?= $value->getId() ?>"><i class="fa fa-minus"></i></a></li>
                                                <li><span style="padding:0; border: 0"><input id="number-<?= $value->getId() ?>" type="text" style="width: 55px; height: 34px; text-align: center; font-size: 15px;" data-id="<?= $value->getId() ?>" data-value="<?= $value->getQuantity() ?>" value="<?= $value->getQuantity() ?>" class="number"></span></li>
                                                <li><a href="javascript:void(0)" class="augment" data-type="augment" data-id="<?= $value->getId() ?>"><i class="fa fa-plus"></i></a></li>
                                            </ul>
                                            <p id="msg-<?= $value->getId() ?>" style="color:red; clear: both;"><small></small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pull-left">
                                    <?= Yii::t('frontend', 'Tổng tiền') ?>
                                </div>
                                <div class="pull-right text-danger total">
                                    <?= Yii::t('frontend', 'Tạm tính') ?> <span><?= number_format($price, 0, '', '.') ?></span> ₫
                                </div>

                            </div>
                        </div>
                        <div class="row form_order" style="border-top: 1px solid #ccc; padding-top: 20px; margin-top: 20px">
                            <div class="col-sm-12">		
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'name')->textInput(['placeholder' => Yii::t('frontend', 'Họ tên')])->label(FALSE) ?>
                                        <?= $form->field($model, 'phone')->textInput(['placeholder' => Yii::t('frontend', 'Điện thoại')])->label(FALSE) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(FALSE) ?>
                                        <?php
                                        $array = [];
                                        foreach ($province->getItems() as $value) {
                                            $array[(string) $value['_id']] = $value['name'];
                                        }
                                        ?>
                                        <?= $form->field($model, 'province')->dropDownList($array, ['class' => 'form-control select2-select', 'prompt' => Yii::t('common', 'Tỉnh thành')])->label(FALSE) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'district')->dropDownList([], ['class' => 'form-control select2-select', 'prompt' => Yii::t('common', 'Quận/Huyện')])->label(FALSE) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($model, 'ward')->dropDownList([], ['class' => 'form-control select2-select', 'prompt' => Yii::t('common', 'Phường/Xã')])->label(FALSE) ?>
                                    </div>
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'address')->textInput(['placeholder' => Yii::t('common', 'Địa chỉ (số nhà, đường)')])->label(FALSE) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">	
                                <div class="payment-method">
                                    <div class="payment-accordion">

                                        <div class="order-button-payment text-center">
                                            <input type="submit" class="btn btn-success" style="padding: 6px 24px" value="<?= Yii::t('frontend', 'Đặt hàng') ?>">
                                        </div>								
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                ActiveForm::end();
                ?>
                <?php
            } else {
                ?>
                <div style="text-align: center; margin: 50px auto">
                    <img src="/template/images/cart.png" style="width: 250px">
                    <p><?= Yii::t('frontend', 'Bạn không có sản phẩm nào trong giỏ hàng') ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php ob_start(); ?>
<script type="text/javascript">
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
                    option_ward += '<option value><?= Yii::t('common', 'Phường/Xã') ?></option>';
                    option += '<option value><?= Yii::t('common', 'Quận/Huyện') ?></option>';
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
                    option += '<option value><?= Yii::t('common', 'Phường/Xã') ?></option>';
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
                    $(".total span").html(data.total);
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
                }
            },
        });
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>