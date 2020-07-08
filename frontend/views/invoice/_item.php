<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use common\components\Constant;
?>

<div class="panel panel-default panel-order">
    <div class="panel-heading">
        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['invoice/view/' . $model["_id"]]) ?>">
            <div class="pull-left">
                <p><?= \Yii::t('common', 'Đơn hàng') ?> #<?= $model['code'] ?></p>
                <small><?= \Yii::t('common', 'Ngày đặt hàng') ?> <?= date('d/m/Y', $model['created_at']) ?></small>
            </div>
            <div class="pull-right" style="padding-top: 10px">
                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['invoice/view/' . $model["_id"]]) ?>"><?= \Yii::t('common', 'Chi tiết') ?></a>
            </div>
        </a>
    </div>
    <div class="panel-body">
        <?php
        foreach ($model->product as $value) {
            ?>
            <div class="row order-item" style="margin-top: 15px">
                <div class="col-sm-5 col-xs-12 ">
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/' . $value["id"] . '-' . $value['id']]) ?>">
                        <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value['image'] ?>&size=60x60" style="margin-bottom: 10px; border-radius: 4px; float: left; margin-right: 10px">
                        <div>
                            <?= Yii::t('product', $value['title']) . (!empty($value['type']) ? ' (' . \Yii::t('common', 'Loại') . ' ' . $value['type'] . ')' : '') ?>
                        </div>
                    </a>
                </div>
                <div class="col-sm-2  col-xs-12">
                    <?= \Yii::t('common', 'Số lượng') ?>: <?= $value['quantity'] ?> <?= Yii::t('common', $value['unit']) ?>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <?= \Yii::t('common', 'Giá') ?>: <?= $value['price'] ?>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <?= \Yii::t('common', 'Thành tiền') ?>: <?= $value['price'] * $value['quantity'] ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>