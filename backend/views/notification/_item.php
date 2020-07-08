<?php

use common\components\Constant;
?>
<li id="item-<?= (string)$model['_id'] ?>" class="item " style=" padding: 10px; border-bottom: 1px solid #ddd;">

    <a data-id="<?= $model->id ?>" href="javascript:void(0)" class="read" data-href="<?= $model['url'] ?>">
        <p style="margin:0"><?= $model['content'] ?></p>
        <span  class="time"><i class="fas fa-clock"></i> <?= Constant::time($model['created_at']) ?></span>
    </a>
    <?php
    if ($model['status'] == 1) {
        ?>
        <a class="remove pull-right" data-id="<?= (string)$model['_id'] ?>" title="Đánh dấu đã đọc" href="javascript:void(0)"><i class="fa fa-remove"></i></a>
        <?php
    } else {
        ?>
        <a class="check-read pull-right" data-id="<?= (string)$model['_id'] ?>" title="Đánh dấu đã đọc" href="javascript:void(0)"><i class="fa fa-eye"></i></a>
            <?php
        }
        ?>
</li>

