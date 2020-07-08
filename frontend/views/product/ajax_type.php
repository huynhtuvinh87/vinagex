<?php
if (!empty($model->approx)) {
    ?>
    <div class="list-price" style="margin-top:15px; margin-bottom: 15px;">

        <ul>
            <?php
            foreach ($model->approx as $value) {
                ?>
                <li>
                    <p class="text-red"><?= Constant::price($value['price']) ?> đ</p>
                    <?= $value['quantity_min'] ?> - <?= $value['quantity_max'] ?> <span class="unit"><?= $model->unit ?></span>
                </li>
                <?php
            }
            ?>
        </ul>

    </div>
    <?php
} elseif (!empty($model->classify)) {
    for ($i = 0; $i < $count; $i++) {
        ?>
        <div id="list-price-<?= $i ?>" class="list-price" style="display:<?= $i == 0 ? "block" : "none" ?>">
            <p><small>
                    <?php
                    if (!empty($model->classify[$i]['description'])) {
                        echo 'Lưu ý: ' . $model->classify[$i]['description'];
                    }
                    ?>
                </small>
            </p>
            <div style="width:100%; overflow: hidden; padding-bottom: 10px">

                <ul>
                    <?php
                    if (!empty($model->classify[$i]['frame'])) {
                        foreach ($model->classify[$i]['frame'] as $k => $val) {
                            ?>
                            <li>
                                <p class="text-red"><?= Constant::price($val['price']) ?> đ</p>
                                <?= $val['quantity_min'] ?> - <?= $val['quantity_max'] ?>  <span class="unit"><?= $model->unit ?></span>
                                <input type="hidden" class="<?= $k == 0 ? 'number-qty' : '' ?>" value="<?= $val['quantity_max'] ?>">
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li>
                            <p class="text-red"><?= Constant::price($model->classify[$i]['price_min']) ?> đ</p>
                            <?= $model->classify[$i]['quantity'] ?>  <span class="unit"><?= $model->unit ?></span>
                            <input type="hidden"  class="number-qty" value="<?= $model->classify[$i]['quantity'] ?>">
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>


        </div>

        <?php
    }
}
?>
<div class="quantity">
    <label>Số lượng</label> <i class="fa fa-minus" aria-hidden="true"></i>
    <input type="text" id="cart-quantity" name="Cart[quantity]" class="qty" value="<?= $model['quantity'] ?>"> <i class="fa fa-plus" aria-hidden="true"></i>
    <input type="hidden" id="cart-kind" name="Cart[kind]" value="<?= !empty($model->classify) ? 1 : 0 ?>">
    <span class="unit"><?= $model->unit ?></span>
</div>