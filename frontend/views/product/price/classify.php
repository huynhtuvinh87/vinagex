<?php

use common\components\Constant;

$qtt_default = [];

$array = [];
foreach ($model->classify as $value) {
    if ($value['status'] == 1) {
        $array[] = $value;
    }
}
if (count($array) > 0) {
    ?>
    <div class="list-kind">
        <div class="btn-group" role="group" id="classify_type">
            <?php
            foreach ($array as $i => $item) {
                $qtt_max = $item['quantity_stock'];
                if (!empty($item['frame'])) {
                    $qtt[$i] = $price[$i] = [];
                    foreach ($item['frame'] as $k => $val) {
                        if (($val['quantity_max'] <= $qtt_max) or ( $val['quantity_min'] <= $qtt_max && $qtt_max <= $val['quantity_max'])) {
                            $qtt[$i][] = $val['quantity_min'];
                            $qtt[$i][] = $val['quantity_max'];
                            $price[$i][] = $val['price'];
                        }
                    }
                    if (min($price[$i]) == max($price[$i])) {
                        $p = Constant::price(min($price[$i]));
                    } else {
                        $p = Constant::price(min($price[$i])) . ' - ' . Constant::price(max($price[$i]));
                    }
                    ?>
                    <button type="button" class="btn btn-default <?= $i == 0 ? "active" : "" ?>"  data-key="<?= $item['id'] ?>" data-price="<?= $p ?>" data-min="<?= min($qtt[$i]) ?>"  data-max="<?= $qtt_max > 0 ? $qtt_max : max($qtt[$i]) ?>"><?= Yii::t('common', 'Loại') . ' ' . $item['id'] ?></button>
                    <?php
                } else {
                    ?>
                    <button type="button" class="btn btn-default <?= $i == 0 ? "active" : "" ?>"  data-key="<?= $item['id'] ?>" data-price="<?= Constant::price($item['price_min']) ?>" data-min="<?= $item['quantity_min'] ?>"  data-max="<?= $qtt_max > 0 ? $qtt_max : $item['quantity_stock'] ?>"><?= Yii::t('common', 'Loại') . ' ' . $item['id'] ?></button>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
    foreach ($array as $i => $item) {
        $qtt_max = $item['quantity_stock'];
        ?>
        <div id="list-price-<?= $item['id'] ?>" class="list-price  <?= $i == 0 ? "show" : "hide" ?>">
            <p>
                <small>
                    <?php
                    if (!empty($item['description'])) {
                        echo \Yii::t('common', 'Lưu ý') . ': ' . $item['description'];
                    }
                    ?>
                </small>
            </p>
            <div style="width:100%; overflow: hidden;">

                <ul class="row">
                    <?php
                    if (!empty($item['frame'])) {
                        foreach ($item['frame'] as $k => $val) {
                            if (($val['quantity_max'] <= $qtt_max) or ( $val['quantity_min'] <= $qtt_max && $qtt_max <= $val['quantity_max'])) {
                                if ($k > 0) {
                                    ?>
                                    <li class="col-xs-3 col-sm-3  price_<?= $k + 1 ?>">
                                        <p class="text-red"><?= Constant::price($val['price']) ?> đ</p>
                                        <?php
                                        if ($val['quantity_max'] > $qtt_max && (($qtt_max - $val['quantity_min']) < 2)) {
                                            $qtt = $val['quantity_min'];
                                        } elseif ($val['quantity_max'] > $qtt_max) {
                                            $qtt = $val['quantity_min'] . ' - ' . $qtt_max;
                                        } else {
                                            $qtt = $val['quantity_min'] . ' - ' . $val['quantity_max'];
                                        }
                                        ?>

                                        <?= $qtt ?> <span class="unit"><?= Yii::t('common', $model->unit) ?></span>
                                    </li>
                                    <?php
                                } else {
                                    if ($val['quantity_max'] < $qtt_max) {
                                        ?>
                                        <li class="col-xs-3 col-sm-3  price_<?= $k + 1 ?>">
                                            <p class="text-red"><?= Constant::price($val['price']) ?> đ</p>
                                            <?php
                                            if ($val['quantity_max'] > $qtt_max && (($qtt_max - $val['quantity_min']) < 2)) {
                                                $qtt = $val['quantity_min'];
                                            } elseif ($val['quantity_max'] > $qtt_max) {
                                                $qtt = $val['quantity_min'] . ' - ' . $qtt_max;
                                            } else {
                                                $qtt = $val['quantity_min'] . ' - ' . $val['quantity_max'];
                                            }
                                            ?>

                                            <?= $qtt ?> <span class="unit"><?= Yii::t('common', $model->unit) ?></span>
                                        </li>
                                        <?php
                                    } else {
                                        ?>
                                        <?= \Yii::t('common', 'Còn lại') ?>: <?= $qtt_max ?> <span class="unit"><?= Yii::t('common', $model->unit) ?></span>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <input type="hidden" class="<?= $k == 0 ? 'number-qty' : '' ?>" value="<?= $val['quantity_max'] ?>">
                            <?php
                        }
                        ?>
                        <?php
                    } else {
                        ?>

                        <?= \Yii::t('common', 'Còn lại') ?>: <?= $qtt_max ?> <span class="unit"><?= Yii::t('common', $model->unit) ?></span>
                        <?php
                    }
                    ?>
                </ul>


            </div>

        </div>

        <?php
    }
    ?>
    <div class="quantity">
        <label><?= \Yii::t('common', 'Số lượng') ?></label> <i class="fa fa-minus" aria-hidden="true"></i>
        <input type="number" id="cart-quantity" name="Cart[quantity]" class="qty" value="" min="" max=""> <i class="fa fa-plus" aria-hidden="true"></i>
        <input type="hidden" id="cart-kind" name="Cart[kind]" value="">
        <span class="unit"><?= Yii::t('common', $model->unit) ?></span>
        <p style="margin-top:10px; color: red; margin-bottom: -10px"><small id="quantity-error"></small></p>
    </div>
    <?php
}
?>
<?php ob_start(); ?>

<script type="text/javascript">
    $(".product-price").show();
    var price = $("#classify_type button.active").attr('data-price');
    $(".product-price .orange").html(price);
    var min = $("#classify_type .active").attr('data-min');
    var max = $("#classify_type .active").attr('data-max');
    $("#cart-quantity").attr('min', min);
    $("#cart-quantity").attr('max', max);
    $("#cart-quantity").val(min);
    $("#cart-kind").val($("#classify_type .active").attr('data-key'));
    $(".list-kind .btn").on("click", function (event, state) {
        var key = $(this).attr('data-key');
        var min = $(this).attr('data-min');
        var max = $(this).attr('data-max');
        $(".list-kind .btn").removeClass('active');
        $(this).addClass('active');
        $('.dropdown-classify a small').html($(this).text());
        $(".list-price").addClass('hide');
        $(".list-price").removeClass('show');
        $("#list-price-" + key).addClass('show');
        $("#list-price-" + key).removeClass('hide');
        var price = $(this).attr("data-price");
        $(".product-price .orange").html(price);
        $("#cart-quantity").val(min);
        $("#cart-kind").val(parseInt(key));
        $("#cart-quantity").attr('min', min);
        $("#cart-quantity").attr('max', max);
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
