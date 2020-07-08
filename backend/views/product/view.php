<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;
use common\widgets\Alert;
use common\components\Constant;
use frontend\storage\SellerItem;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$userSeller = $model->user;
$seller = new SellerItem($model->owner['id']);
if ($model->price['min'] == $model->price['max']) {
    $price = Constant::price($model->price['min']);
} else {
    $price = Constant::price($model->price['min']) . ' - ' . Constant::price($model->price['max']);
}
$count = count($model->classify);
?>
<?= Alert::widget() ?>
<div class="row">
    <div class="col-md-9 product-detail">
        <div class="row product-detail-inner">
            <div class="col-md-5">
                <a href="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $model->images[0] ?>&size=350x350" rel="group"><img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $model->images[0] ?>&size=350x350 " alt="áo"></a>     
            </div>

            <div class="col-md-6">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form']]); ?>
                <h1 class="product-title"><?= $model->title ?></h1>
                <div class="product-price" style="display: inline-flex; width: 100%; margin: 10px 0; font-size: 18px; color: red">
                    <span><?= $price ?> đ/<span class="unit"><?= $model->unit ?></span></span>  
                </div>
                <?php
                if (!empty($model->approx)) {
                    ?>
                    <div class="list-price" style="margin-top:15px; margin-bottom: 15px;">

                        <ul>
                            <?php
                            foreach ($model->approx as $value) {
                                ?>
                                <li>
                                    <p class="text-red"><?= Constant::price($value['price']) ?> đ</p>
                                    <?= $value['quantity_min'] ?> - <?= $value['quantity_max'] ?> <span class="unit"><?= $model->unit ?></span>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>

                    </div>
                    <?php
                } elseif ($model->price_type == 3) {
                    ?>
                    <div class="list-kind">
                        <div class="btn-group" role="group">
                            <?php
                            for ($i = 0; $i < $count; $i++) {
                                ?>
                                <button type="button" class="btn btn-default <?= $i == 0 ? "active" : "" ?>"  data-key="<?= $i ?>"><?= $model->classify[$i]['kind'] ?></button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($i = 0; $i < $count; $i++) {
                        ?>
                        <div id="list-price-<?= $i ?>" class="list-price" style="display:<?= $i == 0 ? "block" : "none" ?>">
                            <p>
                                <?php
                                if (!empty($model->classify[$i]['description'])) {
                                    echo 'Lưu ý: ' . $model->classify[$i]['description'];
                                }
                                ?>
                            </p>
                            <div style="width:100%; overflow: hidden; padding-bottom: 10px">

                                <ul>
                                    <?php
                                    if (!empty($model->classify[$i]['frame'])) {
                                        foreach ($model->classify[$i]['frame'] as $k => $val) {
                                            ?>
                                            <li>
                                                <p class="text-red"><?= Constant::price($val['price']) ?> đ</p>
                                                <?= $val['quantity_min'] ?> - <?= $val['quantity_max'] ?>  <span class="unit"><?= $model->unit ?></span>
                                                <input type="hidden" class="<?= $k == 0 ? 'number-qty' : '' ?>" value="<?= $val['quantity_max'] ?>">
                                            </li>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <li>
                                            <p class="text-red"><?= Constant::price($model->classify[$i]['price_min']) ?> đ</p>
                                            <?= $model->classify[$i]['quantity_min'] ?>  <span class="unit"><?= $model->unit ?></span>
                                            <input type="hidden"  class="number-qty" value="<?= $model->classify[$i]['quantity_min'] ?>">
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>


                        </div>

                        <?php
                    }
                }
                ?>
                <div style="clear: both;"></div>
                <div class="transport">
                    Hình thức thanh toán: <?= $seller->getPayment() ?>
                </div>
                <div class="button-group">
                    <div class="item item-buy">
                        <div class="item-wrap">
                            <?php if ($model->status == Constant::STATUS_NOACTIVE) { ?>
                                <button type="submit" name="buynow" class="btn btn-primary">Duyệt</button>
                                <a class="btn btn-danger cancel" href="/product/cancel/<?= $model->id?>">Từ chối</a>
                            <?php } ?>

                            <?php if ($model->status == Constant::STATUS_ACTIVE) { ?>
                                <button type="submit" name="buynow" class="btn btn-primary">Khóa</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                            <!--<div class="label-download-app"><a target="_blank" href="#"><span class="hot-tag">HOT</span> <strong>Tải ứng dụng Mua Sỉ</strong> để nhận được giá sỉ tốt hơn mỗi ngày!</a></div>-->

            </div>
        </div>

        <div class="row">
            <div class="sec-pro">
                <h3 class="sec-title">Mô tả sản phẩm</h3>
                <div class="sec-content">
                    <?= nl2br($model->content) ?>
                </div>
            </div>
        </div>



    </div>
    <div id="sidebar" class="col-md-3">
        <div class="sb-section detail-company">
            <div class="sb-content">
                <p class="sb-sub">Được cung cấp bởi</p>
                <p class="sale-place"> <a target="_bank" href="/nha-vuon/<?= $model->user->username ?>"><?= $seller->getGardenName() ?></a></p>
                <div class="rating">
                    <?php
                    if ($model->countReview > 0) {
                        ?>
                        <div class="star">
                            <div class="empty-stars"></div>
                            <div class="full-stars" style="width:<?= $seller->getTotalReview() * 20 ?>%"> </div>

                        </div>
                        <small>( <?= $model->user->countReview ?> đánh giá )</small>
                        <?php
                    }
                    ?>
                </div>
                <div class="line"></div>
                <ul class="row list-info">
                    <li class="col-xs-5">Ngày tham gia </li>
                    <li class="col-xs-7"><?= $seller->getCreated() ?></li>
                    <div style="clear: both;"></div>
                    <li class="col-xs-5"> Giao dịch</li>
                    <li class="col-xs-7 has-color">Đã giao dịch <strong><?= $seller->getCountDeal() ?></strong> lần</li>
                    <li class="col-xs-5">Tỷ lệ giao dịch</li>
                    <li class="col-xs-7 has-color"><strong><?= $seller->getPercentageDeal() ?>%</strong> tỉ lệ xử lý đơn hàng</li>
                    <div style="clear: both;"></div>
                    <li class="col-xs-5">Địa chỉ</li>
                    <li class="col-xs-7"><?= $seller->getAddress() ?></li>
                    <li class="col-xs-5">Thương hiệu</li>
                    <li class="col-xs-7"><?= $seller->getTrademark() ?></li>
                    <?php
                    if ($seller->getCertificate()) {
                        ?>
                        <li class="col-xs-5">Tiêu chuẩn</li>
                        <li class="col-xs-7"><?= $seller->getCertificate() ?></li>
                        <?php
                    }
                    ?>
                    <li class="col-xs-5">Quy mô</li>
                    <li class="col-xs-7"><?= $seller->getAcreage() ?> héc ta</li>
                    <li class="col-xs-5">Sản lượng cung cấp</li>
                    <li class="col-xs-7"><?= $seller->get0utputProvided() ?> Tấn/vụ</li>
                        <?php
                        if ($seller->getMoney()) {
                            echo '<li class="col-xs-12">' . $seller->getMoney() . '</li>';
                        }
                        ?>

                </ul>
            </div>
        </div>
    </div> 
</div>
<?php ob_start(); ?>
<script type="text/javascript">
    $(".list-kind .btn").on("click", function (event, state) {
        var key = $(this).attr('data-key');
        $(".list-kind .btn").removeClass('active');
        $(this).addClass('active');
        $(".list-price").hide();
        $("#list-price-" + key).show();
    });

    
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>



