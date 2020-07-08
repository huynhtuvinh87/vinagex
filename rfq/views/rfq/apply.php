<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\ActiveForm;
use common\components\Constant;
use rfq\storage\RfqItem;

$item = new RfqItem($rfq);
?>
<?php
if (Yii::$app->roletype->isSeller()) {
    $form = ActiveForm::begin([
                'id' => 'formOffer',
    ]);
    ?>
    <div class="form-group">
        <p><?= Yii::t('rfq', 'Báo giá') ?></p>
        <div class="row">
            <div class="col-xs-12 col-sm-5">
                <?= $form->field($model, 'price')->textInput(['value' => !empty($rfq['price']) ? $rfq['price'] : '', 'placeholder' => Yii::t('rfq', 'Nhập giá bạn mong muốn')])->label(false) ?>
            </div>
            <div class="col-xs-12">
                <?= $form->field($model, 'description')->textarea(['placeholder' => Yii::t('rfq', 'Thông tin thêm cho người bán')])->label(Yii::t('rfq', 'Mô tả')) ?>
            </div>
            <div class="col-xs-12 col-sm-4">
                <button type="submit" class="btn btn-success" style="width: 100%"><?= Yii::t('rfq', 'Gửi báo giá') ?></button>
            </div>
        </div>
    </div>
    <div class="form-group">
        <p><strong><?= Yii::t('rfq', 'Thông tin sản phẩm') ?></strong></p>
        <dl class="dl-horizontal">
            <dt><?= Yii::t('rfq', 'Thời gian cung cấp') ?>: </dt><dd><?= $item->getDatestart() ?></dd>
            <dt><?= Yii::t('rfq', 'Thời gian hết hạn') ?>:</dt><dd><?= $item->getDateend() ?></dd>
            <dt><?= Yii::t('rfq', 'Tên sản phẩm') ?>:</dt><dd><?= $item->getTitle() ?></dd>
            <dt><?= Yii::t('rfq', 'Số lượng cần mua') ?>:</dt><dd><?= $item->getQuantity() ?></dd>
        </dl>
        <p><?= nl2br(Yii::t('rfq', $item->getContent())) ?></p>
        <?php
        if (!empty($rfq['images'])) {
            ?>
            <p><strong><?= Yii::t('rfq', 'Hình ảnh sản phẩm') ?></strong></p>
            <ul class="list-unstyled list-images">
                <?php
                for ($i = 0; $i < count($rfq['images']); $i++) {
                    ?>
                    <li class="text-center">
                        <a data-lightbox="roadtrip" href="<?= Constant::domain('cdn') ?>/<?= $rfq['images'][$i] ?>"><img src="<?= Constant::domain('cdn') ?>/image.php?src=<?= $rfq['images'][$i] ?>" width="100"></a>
                    </li>

                    <?php
                }
                ?>
            </ul>
            <?php
        }
        ?>
    </div>

    <?php
    ActiveForm::end();
} else {
    echo Yii::t('rfq', 'Tài khoản của bạn không đủ điều kiện để báo giá, xin cập nhật tài khoản tại đây: <a href="{url}">Tài khoản bán hàng</a>', ['url' => Yii::$app->setting->get('siteurl_seller') . '/seller']);
}
?>

<?php ob_start(); ?>
<script type="text/javascript">
    var cleave = new Cleave('#applyform-price', {
        numeral: true,
        blocks: [5],
        numeralThousandsGroupStyle: 'thousand'
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>