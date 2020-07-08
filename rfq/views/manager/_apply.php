<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use common\components\Constant;
use rfq\storage\RfqApply;

$item = new RfqApply($model);
?>
<div class="list_item">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <ul class="list-unstyled">
                <li><?= Yii::t('rfq', 'Tên sản phẩm') ?>: <b><?= $item->getTitle() ?></b></li>
                <li><?= Yii::t('rfq', 'Thời gian: {0} đến {1}', ['<b>' . $item->getDatestart() . '</b>', '<b>' . $item->getDateend() . '</b>']) ?></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-2">
            <ul class="list-unstyled">
                <li><?= Yii::t('rfq', 'Số lượng') ?>:  <b><?= $item->getQuantity() ?></b></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-4">
            <ul class="list-unstyled">
                <li><?= Yii::t('rfq', 'Bạn báo giá') ?>:  <b><?= $item->getPriceOffer() ?> vnđ</b></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-2">
            <div class=" pull-right">
                <p class="status-request"><?= Constant::STATUS_SHOW_APPLY[$model['status']] ?></p>
                <?php if ($item->checkActor() && $model['status'] == Constant::STATUS_PENDING) { ?>
                    <?=
                    Html::a('<i class="fas fa-times-circle" style="color: #f44336;"></i> ' . Yii::t('rfq', 'Hủy'), '/manager/cancel/' . (string) $model['_id'], [
                        'title' => Yii::t('rfq', 'Hủy'),
                        'data-confirm' => Yii::t('rfq', 'Bạn có muốn hủy báo giá này ?'),
                        'data-method' => 'post',
                        'class' => 'btn btn-xs btn-danger'
                    ])
                    ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
