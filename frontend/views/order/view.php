<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use common\components\Constant;
use yii\bootstrap\ActiveForm;

$this->title = 'Đơn hàng #' . $model['code'];
$this->params['breadcrumbs'][] = ['label' => 'Đơn hàng của bạn', 'url' => ['/tra-cuu-don-hang?key=' . $model['phone']]];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(['id' => 'orderStatus']); ?>
<div class="container">
    <h2 style="margin-top: 0">Chi tiết đơn hàng</h2>
    <div class="detail-info">
        <div class="pull-left">
            <p class="order-number"><?= $this->title ?></p>
            <p class="light-gray">Đặt ngày <?= date('d-m-Y', $model['created_at']) ?></p>
        </div>
        <div class="detail-right-info pull-right"><span class="detail-info-total-title">Tổng cộng: </span><span class="detail-info-total-value"><?= Constant::price($model->total) ?> VNĐ</span></div>
    </div>
    <?php
    foreach ($model->getProducts() as $value) {
        ?>
        <div class="package">

            <div class="dummy-wrapper">
                <div class="package-header">
                        <div class="img-product">
                             <a target="_blank" href="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value['product']['image'] ?>&size=350x350" rel="group">
                                <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value['product']['image'] ?>&size=40x40">
                            </a>
                                       
                        </div>
                        <div class="infor-seller">
                        <p class="text package-header-text"> <?= $value['product']['title'] ?></p>
                        <p class="text"><small>Cung cấp bởi <span class="link"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/nha-vuon/' . $value['owner']['username']]) ?>"><?= $value['owner']['garden_name'] ?></a></span></small></p>
                        
                        </div>
                <div class="im-chat">
                    <a href="/message/view/<?= $value['product']['id'] ?>">
                        <span class="glyphicon glyphicon-comment"></span>
                        <span>Trò chuyện ngay</span>
                    </a>
                </div>
            </div>
            </div>
            <div id="steps">
                <ul class="option">
                    <li>
                        <div class="step step1 <?= $value['status'] >= Constant::STATUS_ORDER_PENDING ? "done" : "" ?>" data-desc="Đang xử lý" >
                            <i class="icon-valid"></i>
                        </div>
                        <?= $value['status'] == Constant::STATUS_ORDER_PENDING ? '<div class="translate" style="top: 70px; left: 10px"></div>' : "" ?>
                    </li>
                    <li>
                        <div class="step <?= $value['status'] >= Constant::STATUS_ORDER_SENDING ? "done" : "" ?> step2 next" data-desc="Đang giao hàng">
                            <i class="icon-valid"></i>
                        </div>
                        <?= $value['status'] == Constant::STATUS_ORDER_SENDING ? '<div class="translate" style="top: 70px; right: 10px"></div>' : "" ?>
                    </li>
                    <li>
                        <div class="step step3 <?= $value['status'] == Constant::STATUS_ORDER_COMPLETE ? "done" : "" ?>" data-desc="Đã giao hàng">
                            <i class="icon-valid"></i>
                        </div>
                        <?= $value['status'] == Constant::STATUS_ORDER_COMPLETE ? '<div class="translate" style="top: 70px; right: 10px"></div>' : "" ?>
                    </li>
                </ul>
                <div class="dropdown" style="top: 40px;">
                    <ul class="dropdown-menu">
                        <li style="padding: 20px 10px; width: 100%">
                            <?php
                            switch ($value['status']) {
                                case Constant::STATUS_ORDER_PENDING:
                                    echo '<span>' . $value['datetime'] . ' </span>Đơn hàng của bạn đang được xử lý';
                                    break;
                                case Constant::STATUS_ORDER_SENDING:
                                    echo '<span>' . $value['datetime'] . ' </span>Đơn hàng của bạn đang được vận chuyển';
                                    break;
                                case Constant::STATUS_ORDER_COMPLETE:
                                    echo '<span>' . $value['datetime'] . ' </span>Đơn hàng của bạn đang được giao.Xin vui lòng đợi vài ngày. Cám ơn bạn đã mua sắm tại Vinagex.';
                                    break;
                            }
                            ?>

                        </li>
                    </ul>
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
                    <h3 style="margin-top:0">Địa chỉ nhận hàng</h3>
                    <p class="username"><strong>Họ tên: </strong><?= $model->name ?></p>
                    <p class="address"><strong>Địa chỉ: </strong><?= $model->address ?>, <?= $model->ward ?>, <?= $model->district ?>, <?= $model->province ?></p>
                    <p><strong>Số điện thoại: </strong><?= $model->phone ?></p>
                </div>

            </div>
            <div class="col-md-6">
                <div class="total-summary">
                    <div class="rows"><p class="pull-left">Tạm tính: </p><p class="pull-right"><?= Constant::price($model->total) ?> đ</p></div>
                    <div class="rows"><p class="pull-left">Phí vận chuyển: </p><p class="pull-right">Thoả thuận</p></div>
                    <hr>
                    <div class="rows"><p class="pull-left">Thành tiền: </p><p class="pull-right total-price"><?= Constant::price($model->total) ?> đ</p></div>
                    <div class="rows"><p class="pull-left">Thanh toán bằng hình thức Thanh toán khi nhận hàng</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php ob_start(); ?>
<script type="text/javascript">
//        $('.done').html('<i class="icon-valid"></i>');
//        $('.step').each(function (index, el) {
//            $(el).not('.active').addClass('done');
//            $('.done').html('<i class="icon-valid"></i>');
//            if ($(this).is('.active')) {
//                $(this).parent().addClass('pulse')
//                return false;
//            }
//        });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
