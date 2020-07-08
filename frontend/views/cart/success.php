<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use frontend\components\SendMail;

$this->title = \Yii::t('common', 'Đặt hàng thành công');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 order-success">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <h2><?= \Yii::t('common', 'Đặt hàng thành công') ?></h2>
                    <p>
                        <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=images/checked.png&size=120x120">
                    </p>
                    <p><?= \Yii::t('common', 'Cảm ơn quý khách đã cho chúng tôi cơ hội phục vụ.') ?><br> <?= \Yii::t('common', 'Nhân viên Vinagex sẽ liên hệ cho quý khách để xác nhận') ?></p>
                    <p><?= \Yii::t('common', 'Mọi thắc mắc vui lòng liên hệ 0843286386 hoặc để lại tin nhắc tại đây.') ?></p>
                    <div class="row">
                        <div class="col-xs-6"><a style="width: 100%" href="/" class="btn btn-primary"><?= \Yii::t('common', 'Tiếp tục mua hàng') ?></a></div>
                        <div class="col-xs-6"><a style="width: 100%" href="/invoice/view/<?= $id ?>" class="btn btn-primary"><?= \Yii::t('common', 'Xem chi tiết đơn hàng') ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
