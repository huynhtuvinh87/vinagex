<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use rfq\storage\RfqItem;
use common\components\Constant;

$item = new RfqItem($model);
?>

<div class="list_item">
    <div class="row">
        <div class="col-xs-12 item">
            <div class="media">
                <div class="media-left img">
                    <a href="<?= $item->getUrl() ?>"><img src="<?= $item->getImg() ?>" class="media-object"></a>
                </div>
                <div class="media-body">
                    <div class="img-mobile">
                        <a href="<?= $item->getUrl() ?>"><img src="<?= $item->getImg() ?>"></a>
                    </div>
                    <div class="title">
                        <h4 class="media-heading"><b><a href="<?= $item->getUrl() ?>"><?= Yii::t('rfq', $item->getTitle()) ?></a></b> <span class="badge badge-success badge-pill"><?= $item->countOffer() ?> <?= Yii::t('rfq', 'Báo giá') ?></span></h4>
                        <p><small><?= Yii::t('common', 'Danh mục') ?>: <b><a href="<?= \Yii::$app->request->hostInfo ?>/?category=<?= $item->getCategoryId() ?>"><?= $item->getCategory() ?></a></b> | <?= Yii::t('rfq', 'Yêu cầu bởi') ?>: <a target="_blank" href="<?= Yii::$app->setting->get('siteurl') . '/user/view/' . $model['owner']['id'] ?>"><?= $model['owner']['fullname'] ?></a></small></p>
                    </div>
                    <div style="clear: both"></div>
                    <div class="row">
                        <div class="col-sm-9 media-body-left">
                            <p><?= Yii::t('rfq', 'Số lượng cần mua') ?>:  <b><?= $item->getQuantity() ?></b></p>
                            <p><?= Yii::t('rfq', 'Ngày mua / hết hạn') ?>: <b> <?= Yii::t('rfq', '{start} đến {end}', ['start' => $item->getDatestart(), 'end' => $item->getDateend()]) ?></b></p>
                        </div>
                        <div class="col-sm-3 media-body-right text-right">
                            <div class="col_sub_left book_now">
                                <?php
                                if (!\Yii::$app->user->isGuest) {
                                    if (!$item->checkOwner()) {
                                        if ($item->checkOffer()) {
                                            if ($item->checkOfferStatus()) {
                                                ?>
                                                <p><?= Constant::STATUS_SHOW_APPLY[$item->checkOfferStatus()] ?></p>
                                                <?php
                                            } else {
                                                ?>
                                                <p><button class="btn btn-sm btn-primary offer"><?= Yii::t('rfq', 'Đã báo giá') ?></button></p>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <p><button class="btn btn-sm btn-danger offer" data-id="<?= (string) $model['_id'] ?>"><?= Yii::t('rfq', 'Báo giá') ?></button></p>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <a class="btn btn-sm btn-danger" href="<?= Yii::$app->setting->get('siteurl_id') ?>/login?url=<?= Constant::redirect(Constant::domain('rfq')) ?>"><?= Yii::t('rfq', 'Báo giá') ?></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
