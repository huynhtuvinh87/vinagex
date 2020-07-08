<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use common\components\Constant;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->title = \Yii::t('common', 'Đơn hàng') . ' #' . $invoice['code'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Đơn hàng của tôi'), 'url' => ['/invoice/history']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(['id' => 'orderStatus']); ?>
<h4 class="detail-order" style="margin-top: 0; font-weight: 400; text-transform: uppercase;"><?= \Yii::t('common', 'Chi tiết đơn hàng') ?></h4>
<div class="detail-info">
    <div class="pull-left">
        <p class="order-number"><?= $this->title ?></p>
        <p class="light-gray"><?= \Yii::t('common', 'Ngày đặt hàng') ?> <?= date('d-m-Y', $invoice['created_at']) ?></p>
    </div>
    <div class="detail-right-info pull-right"><span class="detail-info-total-title"><?= \Yii::t('common', 'Tổng tiền') ?>: </span><span class="detail-info-total-value"><?= Constant::price($invoice->total) ?> VNĐ</span></div>
</div>
<?php
foreach ($order as $k => $value) {
    ?>
    <div class="package" id="<?= $value['code'] ?>">

        <div class="dummy-wrapper">
            <div class="package-header" style="border-bottom: 1px solid #eee; overflow: hidden">
                <div class="infor-seller">
                    <p class="text package-header-text"> <?= \Yii::t('common', 'Kiện hàng') ?> <?= $k + 1 ?></p>
                    <p class="text"><?= \Yii::t('common', 'Cung cấp bởi') ?> <span class="link"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/nha-vuon/' . $value['owner']['username']]) ?>"><?= Yii::t('data', 'seller_garden_name_' . $value['owner']['id']) ?></a></span></p>

                </div>

                <div class="im-chat">
                    <?php
                    if ($value['status'] == Constant::STATUS_ORDER_PENDING) {
                        ?>
                        <p style="margin-top:10px" class="text-red">
                            <?=
                            Html::a(\Yii::t('common', 'Xóa'), '/invoice/delete/' . $value['id'] . '?k=' . $k, [
                                'title' => 'delete',
                                'data-confirm' => \Yii::t('common', 'Bạn có chắc chắn muốn xóa ?'),
                                'data-method' => 'post',
                            ]);
                            ?>
                        </p>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="steps">
            <ul class="option">
                <?php
                if ($value['status'] == Constant::STATUS_ORDER_BLOCK) {
                    ?>
                    <li>
                        <div style="float: left;" class="step step4 active" data-desc="<?= \Yii::t('common', 'Đơn hàng của bạn đã huỷ.') ?>">
                            <i style="font-size: 25px;" class="fa fa-remove"></i>
                        </div>
                        <div class="translate" style="top: 70px; left: 10px"></div>
                    </li>
                    <?php
                } else {
                    ?>
                    <li>
                        <div class="step step1 <?= $value['status'] >= Constant::STATUS_ORDER_PENDING ? "done" : "" ?>" data-desc="<?= \Yii::t('common', 'Đang xử lý') ?>" >
                            <i class="icon-valid"></i>
                        </div>
                        <?= $value['status'] == Constant::STATUS_ORDER_PENDING ? '<div class="translate" style="top: 70px; left: 10px"></div>' : "" ?>
                    </li>
                    <li>
                        <div class="step <?= $value['status'] >= Constant::STATUS_ORDER_SENDING ? "done" : "" ?> step2 next" data-desc="<?= \Yii::t('common', 'Đang giao hàng') ?>">
                            <i class="icon-valid"></i>
                        </div>
                        <?= $value['status'] == Constant::STATUS_ORDER_SENDING ? '<div class="translate" style="top: 70px; right: 10px"></div>' : "" ?>
                    </li>
                    <?php if ($value['status'] == Constant::STATUS_ORDER_UNSUCCESSFUL) { ?>
                        <li>
                            <div class="step step3 unsuccessful" data-desc="<?= \Yii::t('common', 'Không thành công') ?>">
                                <i style="font-size: 20px;" class="glyphicon glyphicon-exclamation-sign"></i>
                            </div>
                            <?= $value['status'] == Constant::STATUS_ORDER_UNSUCCESSFUL ? '<div class="translate" style="top: 90px; right: 10px"></div>' : "" ?>
                        </li>
                    <?php } else { ?>
                        <li>
                            <div class="step step3 <?= $value['status'] == Constant::STATUS_ORDER_FINISH ? "done" : "" ?>" data-desc="success">
                                <i class="icon-valid"></i>
                            </div>
                            <?= $value['status'] == Constant::STATUS_ORDER_FINISH ? '<div class="translate" style="top: 70px; right: 10px"></div>' : "" ?>
                        </li>
                    <?php } ?>
                    <?php
                }
                ?>
            </ul>

            <?php
            switch ($value['status']) {
                case Constant::STATUS_ORDER_PENDING:
                    $date = $value['created_at'] + 86400;
                    ?>
                    <div class="desc">
                        <p><?= \Yii::t('common', 'Sản phẩm của bạn đang đợi nhà cung cấp xử lý!') ?></p>
                        <p><?= \Yii::t('common', 'Đơn hàng sẽ tự động hủy nếu nhà cung cấp không xử lý trước {0} ngày {1}', [date('h:i', $date), date('d/m/Y', $date)]) ?>    </p>
                    </div>
                    <?php
                    break;
                case Constant::STATUS_ORDER_SENDING:
                    ?>
                    <div class="desc">
                        <p><?= \Yii::t('common', 'Đơn hàng của bạn đang được giao') ?></p>
                        <p><?= \Yii::t('common', 'Bắt đầu giao vào lúc: {0} ngày {1}', [date('h:i', $value['date_begin']), date('d/m/Y', $value['date_begin'])]) ?> </p>
                        <p><?= \Yii::t('common', 'Thời gian dự kiến nhận:  {0} ngày {1}', [date('h:i', $value['date_end']), date('d/m/Y', $value['date_end'])]) ?> </p>
                        <?= $value['transport'] ? '<p>' . \Yii::t('common', 'Thông tin người vận chuyển') . ': ' . $value['transport'] . '</p>' : "" ?>
                    </div>
                    <?php
                    break;
                case Constant::STATUS_ORDER_UNSUCCESSFUL:
                    echo '<div style="margin-top: 60px;" class="desc"><p>' . \Yii::t('common', 'Đơn hàng của bạn giao không thành công.') . '<p>';
                    echo "<b>" . \Yii::t('common', 'Lý do') . ": </b>";
                    if (!empty($value->content)) {
                        foreach ($value->content as $reason) {
                            echo '<p>- ' . $reason . '</p>';
                        }
                    }
                    echo "</div>";
                    break;
                case Constant::STATUS_ORDER_FINISH:
                    echo '<div class="desc"><p>' . \Yii::t('common', 'Đơn hàng của quý khách đã được giao thành công. Cám ơn quý khách đã mua sắm tại Vinagex.') . '<p></div>';
                    break;
                case Constant::STATUS_ORDER_BLOCK:
                    echo '<div class="desc"><p>' . \Yii::t('common', 'Đơn hàng của bạn đã huỷ') . '<p>';
                    echo "<b>" . \Yii::t('common', 'Lý do huỷ') . ": </b>";
                    if (!empty($value->content)) {
                        foreach ($value->content as $reason) {
                            echo '<p>- ' . $reason . '</p>';
                        }
                    } else {
                        echo '<p>- ' . \Yii::t('common', 'Đơn hàng bị hủy tự động do trong vòng 24h nhà cung cấp không xử lý đơn hàng.') . '</p>';
                    }
                    echo "</div>";
                    break;
            }
            ?>


        </div>
        <div style="padding: 15px">
            <div class="panel panel-default panel-order">
                <div class="panel-heading" style="padding-left:0">
                    <?= \Yii::t('common', 'Sản phẩm') ?>
                </div>
                <div>
                    <?php
                    foreach ($value->product as $k => $item) {
                        ?>
                        <div class="row order-item" style="margin-top: 15px">
                            <div class="col-sm-5 col-xs-12 ">
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/' . $item["slug"] . '-' . $item['id']]) ?>">
                                    <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $item['image'] ?>&size=60x60" style="margin-bottom: 10px; border-radius: 4px; float: left; margin-right: 10px">
                                    <div>
                                        <?= Yii::t('product', $item['title']) ?>

                                        <?php
                                        if ($value['status'] == Constant::STATUS_ORDER_FINISH) {
                                            ?>
                                            <p style="margin-top:10px">
                                                <button type="button" class="btn btn-primary btn-sm modal-review" data-id="<?= $item['id'] ?>" data-title="<?= $item['title'] ?>"><?= \Yii::t('common', 'Đánh giá') ?></button>
                                            </p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-2  col-xs-12">
                                <?= \Yii::t('common', 'Số lượng') ?>: <?= $item['quantity'] ?> <?= Yii::t('common', $item['unit']) ?>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <?= Constant::price($item['price']) ?> đ
                            </div>
                            <div class="col-sm-3 col-xs-12">
                                <?= \Yii::t('common', 'Tổng tiền') ?>: <?= Constant::price($item['price'] * $item['quantity']) ?> đ
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="row">
    <div class="info-order">
        <div class="col-md-6">

            <div class="delivery-wrapper">
                <h3 style="margin-top:0"><?= \Yii::t('common', 'Thông tin người đặt hàng') ?></h3>
                <p class="username"><strong><?= \Yii::t('common', 'Họ tên') ?>: </strong><?= $invoice->name ?></p>
                <p class="address"><strong><?= \Yii::t('common', 'Địa chỉ') ?>: </strong><?= $invoice->address ?>, <?= $invoice->ward ?>, <?= $invoice->district ?>, <?= $invoice->province ?></p>
                <p><strong><?= \Yii::t('common', 'Điện thoại') ?>: </strong><?= $invoice->phone ?></p>
            </div>

        </div>
        <div class="col-md-6">
            <div class="total-summary">
                <div class="rows"><p class="pull-left"><?= \Yii::t('common', 'Đơn giá') ?>: </p><p class="pull-right"><?= Constant::price($invoice->total) ?> đ</p></div>
                <div class="rows"><p class="pull-left"><?= \Yii::t('common', 'Phí vận chuyển') ?>: </p><p class="pull-right"><?= \Yii::t('common', 'Thỏa thuận') ?></p></div>
                <hr>
                <div class="rows"><p class="pull-left"><b><?= \Yii::t('common', 'Tổng tiền') ?>: </b></p><p class="pull-right total-price"><?= Constant::price($invoice->total) ?> đ</p></div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php ob_start(); ?>
<script type="text/javascript">
    $('.modal-review').click(function () {
        $('#modalHeader span').html($(this).attr('data-title'))
        $.get('/review/index/' + $(this).attr('data-id'), function (data) {

            $('#modal-review').modal('show').find('#modalContent').html(data)
        });
        return false;
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>' . \Yii::t('common', 'Đánh giá sản phẩm') . '</span>',
    'id' => 'modal-review',
    'clientOptions' => ['backdrop' => 'common', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style=\"text-align:center\"><img src=\"/template/images/loading.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>
