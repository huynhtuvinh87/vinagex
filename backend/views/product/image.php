<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div style="max-height: 500px; overflow-y: scroll">
    <input type="hidden" id="product_id" value="<?= $product_id ?>">
    <?php
    foreach ($model as $value) {
        ?>
        <h6>Ngày đăng: <?= date('d/m/Y h:i', $value['created_at']) ?></h6>
        <div class="content">
            <?= $value['content'] ?>
        </div>
        <?php
    }
    ?>
</div>
