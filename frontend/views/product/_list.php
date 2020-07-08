<?php

use common\components\Constant;

if ($model->price['min'] == $model->price['max']) {
    $price = Constant::price($model->price['min']);
} else {
    $price = Constant::price($model->price['min']) . ' - ' . Constant::price($model->price['max']);
}
?>
<div class="item">
    <a href="<?= $model->url ?>" class="thumb"><img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $model->images[0] ?>&size=120x100"></a>
    <div class="product-info">
        <h4 class="title"><a href="<?= $model->url ?>"  title="<?= Yii::t('data', 'product_title_' . $model->id) ?>"><?= Constant::excerpt(Yii::t('data', 'product_title_' . $model->id), 30) ?></a></h4>
        <p class="price_single_same"><?= $price ?> đ</p>
        <?php
        if ($model->countReview > 0) {
            ?>
            <div class="rating">

                <div class="star">
                    <div class="empty-stars"></div>
                    <div class="full-stars" style="width:<?= $model->getTotalReview() * 20 ?>%"> </div>
                </div>
                (<?= $model->countReview ?>)

            </div>
            <?php
        }
        if ($model->number['purchased'] > 0) {
            ?>
            <p><small>Đã mua <?= $model->number['purchased'] ?> <?= $model->unit ?></small></p>
            <?php
        }
        ?>
    </div>
</div>
