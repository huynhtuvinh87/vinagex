<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use rfq\storage\RfqItem;
use common\components\Constant;

$item = new RfqItem($model);
?>

<div class="list_item">
    <div class="row">
        <div class="col-xs-12 item">
            <div class="media">
                <div class="media-left img">
                    <a href="/manager/offer/<?= $item->getId() ?>"><img src="<?= $item->getImg() ?>" class="media-object"></a>
                </div>
                <div class="media-body">
                    <div class="img-mobile">
                        <a href="/manager/offer/<?= $item->getId() ?>"><img src="<?= $item->getImg() ?>"></a>
                    </div>
                    <div class="title">
                        <h4 class="media-heading"><a href="/manager/offer/<?= $item->getId() ?>"><b><?= Yii::t('rfq', $item->getTitle()) ?></b></a> <?= Constant::STATUS_SHOW_RFQ[$model['status']] ?></h4>
                        <p><small><?= Yii::t('common', 'Danh mục') ?>: <b><a href="<?= \Yii::$app->request->hostInfo ?>/?category=<?= $item->getCategoryId() ?>"><?= $item->getCategory() ?></a></b></small></p>
                    </div>
                    <div class="action">
                        <div class="dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="glyphicon glyphicon-option-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php if ($model['status'] != Constant::STATUS_FINISH) { ?>
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-pencil"></i> ' . Yii::t('common', 'Cập nhật'), ['update', 'id' => (string) $model['_id']], [
                                        'class' => 'dropdown-item',
                                    ])
                                    ?>
                                    <?=
                                    Html::a('<i class="glyphicon glyphicon-trash"></i> ' . Yii::t('common', 'Xoá'), ['delete', 'id' => (string) $model['_id']], [
                                        'title' => Yii::t('rfq', 'Xoá'),
                                        'data-confirm' => Yii::t('rfq', 'Bạn có chắc chắn muốn xóa ?'),
                                        'data-method' => 'post',
                                        'class' => 'dropdown-item',
                                    ])
                                    ?>
                                <?php } ?>
                                <?= Html::a('<i class="glyphicon glyphicon-file"></i> ' . Yii::t('rfq', 'Sao chép'), ['move', 'id' => (string) $model['_id']], ['class' => 'dropdown-item']) ?>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both"></div>
                    <div class="row">
                        <div class="col-sm-8 media-body-left">
                            <p><?= Yii::t('rfq', 'Số lượng yêu cầu') ?>:  <b><?= $item->getQuantity() ?></b></p>
                            <p><?= Yii::t('rfq', 'Ngày mua / hết hạn') ?>: <b> <?= Yii::t('rfq', '{start} đến {end}', ['start' => $item->getDatestart(), 'end' => $item->getDatestart()]) ?></b></p>
                        </div>
                        <div class="col-sm-4 media-body-right text-right">
                            <p><a href="/manager/offer/<?= $item->getId() ?>" class="badge badge-success badge-pill"><?= $item->countOffer() ?> <?= Yii::t('rfq', 'Báo giá') ?></a> <a href="/manager/offer/<?= $item->getId() ?>"></a></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
