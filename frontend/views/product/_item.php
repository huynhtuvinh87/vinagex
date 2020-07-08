<?php

use common\components\Constant;
use frontend\storage\ProductItem;

$item = new ProductItem($model);
?>
<div class="item">
    <a class="thumb" href="<?= $item->getUrl() ?>"> <img class="lazyload" data-src="<?= $item->getImage() ?>" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=images/default.gif&size=300x250" alt="<?= $item->getTitle() ?>"> </a>
    <div class="desc">

        <h4 class="title"><a href="<?= $item->getUrl() ?>" title="<?= Yii::t('data', 'product_title_' . $item->getId()) ?>"><?= Constant::excerpt(Yii::t('product', $item->getTitle()), 30) ?></a></h4>
        <div class="price">
            <?= $item->getPrice() ?> đ
            <span>/ <?= Yii::t('common', $model['unit']) ?></span>
        </div>
        <div class="sale-place"><img src="/template/svg/location.svg" width="18"> <a href="<?= $item->getOwnerUrl() ?>"><?= $item->getGardenname() ?></a> </div>
        <div class="bottom">
            <div class="pull-left minimum">
                <?= \Yii::t('common', 'Tối thiểu'); ?> : <?= $item->getMinimum() ?> <?= $item->getUnit() ?>
            </div>
            <?php
            if ($item->getCountReview() > 0) {
                ?>
                <div class="rating pull-right">

                    <div class="star">
                        <div class="empty-stars"></div>
                        <div class="full-stars" style="width:<?= $item->getTotalReview() * 20 ?>%"> </div>
                    </div>
                    (<?= $item->getCountReview() ?>)

                </div>
                <?php
            }
            ?>
        </div>

        <?php
        if ($item->getCountdown()) {
            ob_start();
            $uni = uniqid();
            ?>
            <script type="text/javascript">
                $("#countdown-<?= $uni ?>").countdown("<?= $item->getDateStart() ?> 23:59:59", function (event) {
                    $(this).html(event.strftime('<i class="fa fa-clock-o" aria-hidden="true"></i>Còn %D ngày %H:%M:%S'));
                });
            </script>
            <?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
            <div class="countdown" id="countdown-<?= $uni ?>"></div>
            <?php
        }
        ?>
    </div>
</div>
