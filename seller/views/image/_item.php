<?php

use common\components\Constant;

?>
<div class="product" id="product-<?= $model->id ?>">
    <div class="product-img">
        <a class="remove" title="Xóa sản phẩm" href="/images/delete/<?= $model->id ?>"><i class="fa fa-remove"></i></a>
        <img  class="lazyload" data-src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $model->images[0] ?>&size=250&250"  src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=images/default.gif&size=250x250">
    </div>
   \
</div><!-- item-info -->
