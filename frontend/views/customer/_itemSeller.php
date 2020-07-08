
<div class="col-sm-4">
    <div class="item">
        <div class="shop-banner">
            <?php
            if (!empty($model->seller->images)) {
                $image = Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $model->seller->images[0] . '&size=386x196';
                ?>
                <a href="<?= $model->seller->url ?>"><img  class="lazyload" data-src="<?= $image ?>"  src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=images/default.gif&size=386x196"/></a>
                <?php
            }
            ?>

        </div>
        <div class="shop-info">
            <div class="official-store-name">
                <div class="shop-title">
                    <h1><a href="<?= $model->seller->url ?>"><?= Yii::t('data', 'seller_garden_name_' . $model->seller->id) ?></a></h1>
                </div>
                <p class="paragraph"><?= \Yii::t('common', 'Địa chỉ') ?>: <?= $model->seller->address ?>, <?= $model->seller->ward['name'] ?>, <?= $model->seller->district['name'] ?>, <?= $model->seller->province['name'] ?></p>
            </div>
        </div>
    </div>
</div>