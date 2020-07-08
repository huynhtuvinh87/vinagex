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
        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['order/view/' . $model["_id"]]) ?>">
            <div class="pull-left">
                <p>Đơn hàng #<?= $model['code'] ?></p>
                <small>Đặt ngày <?= date('d/m/Y', $model['created_at']) ?></small>
            </div>
            <div class="pull-right" style="padding-top: 10px">
                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['order/view/' . $model["_id"]]) ?>">QUẢN LÝ</a>
            </div>
        </a>
    </div>
    <div class="panel-body">
        <?php
        foreach ($model->product as $value) {
            ?>
            <div class="row order-item" style="margin-top: 15px">
                <div class="col-sm-2 col-xs-3 left">
                    <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value['image'] ?>&size=60x60" style="margin-bottom: 10px; border-radius: 4px;">
                </div>
                <div class="col-sm-10 col-xs-9 right">
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <?= $value['title'] ?>
                        </div>
                        <div class="col-sm-3  col-xs-6">
                            Số lượng: <?= $value['quantity'] ?> <?= $value['unit'] ?>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <?php
                            switch ($value['status']) {
                                case 1:
                                    echo '<span class="btn btn-default btn-sm">Đang xử lý</span>';
                                    break;
                                case 2:
                                    echo '<span class="btn btn-default btn-sm">Đang giao hàng</span>';
                                    break;
                                case 3:
                                    echo '<span class="btn btn-default btn-sm">Đã giao hàng</span>';
                                    break;
                                case 4:
                                    echo '<span class="btn btn-default btn-sm">Đã huỷ</span>';
                                    break;
                                case 5:
                                    echo '<span class="btn btn-default btn-sm">Giao thành công</span>';
                                    break;
                            }
                            ?>


                            <?php
                            if ($value['status'] == 2) {
                                echo 'Ngày giao ' . $value['datetime'];
                            }
                            ?>

                        </div>
                    </div>
                </div>

            </div>
            <?php
        }
        ?>
    </div>
</div>