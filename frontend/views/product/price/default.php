<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use common\components\Constant;

$qtt_max = $model['quantity_stock'];
?>
<div class="quantity">
    <label><?= \Yii::t('common', 'Số lượng') ?></label> <i class="fa fa-minus" aria-hidden="true"></i>
    <input type="text" id="cart-quantity" name="Cart[quantity]" class="qty" value="<?= $model['quantity_min'] ?>" min="<?= $model['quantity_min'] ?>" max="<?= $model['quantity_stock'] ?>"> <i class="fa fa-plus" aria-hidden="true"></i>
    <input type="hidden" id="cart-kind" name="Cart[kind]" value="0">
    <span class="unit"><?= Yii::t('common', $model->unit) ?></span>
    <p style="margin-top:10px; color: red; margin-bottom: -10px"><small id="quantity-error"></small> </p>
</div>
<?php
if (!empty($model['quantity_purchase']) && $model['quantity_purchase'] > 0) {
    ?>
    <div style="margin-bottom: 10px"><?= \Yii::t('common', 'Còn lại') ?> <?= $model['quantity_stock'] ?> <span class="unit"><?= Yii::t('common', $model->unit) ?></span></div>
        <?php
    }
    ?>
<?php ob_start(); ?>

<script type="text/javascript">
    $(".product-price").show();
    $(".product-price .orange").html("<?= Constant::price($model->price['min']) ?>");

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>