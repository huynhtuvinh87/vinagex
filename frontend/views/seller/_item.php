<?php if (!empty($model->product)) { ?>
    <div class="col-md-4">
        <div class="item">
            <div class="shop-banner">
                <?php
                if (!empty($model->images)) {
                    $image = Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $model->images[0] . '&size=386x196';
                    ?>
                    <a href="<?= $model->url ?>"><img  class="lazyload" data-src="<?= $image ?>"  src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=images/default.gif&size=386x196"/></a>
                    <?php
                }
                ?>

            </div>
            <div class="shop-info">
                <div class="official-store-name">
                    <div class="shop-title">
                        <h1><a href="<?= $model->url ?>"><?= \Yii::t('frontend', $model->garden_name) ?></a></h1>
                    </div>
                    <p class="paragraph"><?= \Yii::t('common', 'Địa chỉ') ?>: <?= $model->address ?>, <?= $model->ward['name'] ?>, <?= $model->district['name'] ?>, <?= $model->province['name'] ?></p>
                </div>
            </div>
            <ul class="list-feature">
                <?php
                foreach ($model->product as $value) {
                    ?>
                    <li><a href="<?= $value->url ?>"><img  class="lazyload" data-src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $value->images[0] . '&size=80x80'; ?>"/></a></li>
                            <?php
                        }
                        ?>
            </ul>
        </div>
    </div>
<?php } ?>