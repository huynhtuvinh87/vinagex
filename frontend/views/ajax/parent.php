<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="list-checkbox" style="display: block">
    <div class="scrollbar-inner">
        <?php
        foreach ($model['parent'] as $type) {
            ?>
            <div class="item">
                <label class="checkbox-square">
                    <input type="checkbox"  id="filter-type_<?= $type['id'] ?>" name="type[]" <?= (!empty($_GET['type']) && in_array($type['id'], $_GET['type'])) ? "checked" : "" ?> value="<?= $type['id'] ?>">
                    <span><?= $type['title'] ?></span>
                </label>
                <span><?= $type['count'] ?></span>

            </div>
            <?php
        }
        ?>
    </div>
</div>