<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="cart">
    <?php
    if (Yii::$app->user->isGuest) {
        ?>
        <a href="javascript:void(0)" data-toggle="modal" data-target=".login-register-form"><img src="/images/cart.png"></a>
        <?php
    } else {
        ?>
        <a href="/cart/basket">
            <img src="/images/cart.png"> <span><?= $count > 0 ? $count : "" ?></span>
        </a>
        <?php
    }
    ?>
</div>