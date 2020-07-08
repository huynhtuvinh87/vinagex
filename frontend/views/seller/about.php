<?php

use common\components\Constant;

$this->title = \Yii::t('common', 'Giới thiệu và đăng ký bán hàng');
?>
<div class="intro-page">
    <div class="banner-intro">
        <div class="container">
            <div class="text-banner">
                <h2><?= \Yii::t('common', 'Nền tảng bán hàng nông sản lớn nhất Việt Nam') ?></h2>
                <p><?= \Yii::t('common', 'Chúng tôi giúp nông dân nhận thêm 20% doanh thu so với cách bán như hiện tại') ?></p>
                <a href="<?= Yii::$app->user->isGuest ? Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_seller')) : Yii::$app->setting->get('siteurl_seller') ?>" class="continue"><?= \Yii::t('common', 'Tham gia ngay') ?></a>
            </div>
        </div>
    </div>
    <div class="special-offer">
        <div class="container">
            <h3><?= \Yii::t('common', 'Hãy trải nghiệm phương thức bán hàng hoàn toàn MIỄN PHÍ') ?></h3>
        </div>
    </div>
    <div class="intro-section intro-1">
        <div class="container">
            <h3><?= \Yii::t('common', 'Tại sao bạn nên tham gia vào Vinagex ?') ?></h3>
            <div class="sales-points">
                <div class="item">
                    <div class="responsive-img">
                        <img alt="Tiếp cận người mua hàng" title="Tiếp cận khách hàng mua sản phẩm" src="/template/images/connect-customer.png" width="96" height="90">
                    </div>
                    <h4><?= \Yii::t('common', 'Tiếp cận hàng triệu người thu mua') ?></h4>
                    <p><?= \Yii::t('common', 'Tham gia vào Vinagex sản phẩm của bạn sẽ được tiếp cận hàng triệu người mua nột cách dễ dàng') ?></p>
                </div>
                <div class="item">
                    <div class="responsive-img">
                        <img alt="Kết nối các đơn vị sản xuất" title="Liên kết với các đơn vị sản xuất khác" src="/template/images/famer-to-famer.png" width="96" height="90">
                    </div>
                    <h4><?= \Yii::t('common', 'Liên kế với các nhà sản xuất khác') ?></h4>
                    <p><?= \Yii::t('common', 'Vinagex có thể giúp bạn liên kết, hợp tác với các đơn vị sản xuất khác để cùng nhau sản xuất và bán hàng') ?></p>
                </div>
                <div class="item">
                    <div class="responsive-img">
                        <img alt="Hỗ trợ kỹ thuật nông nghiệp" title="Được giúp đỡ về kỹ thuật nông nghiệp" src="/template/images/support-famer.png" width="96" height="90">
                    </div>
                    <h4><?= \Yii::t('common', 'Hỗ trợ kỹ thuật nông nghiệp') ?></h4>
                    <p><?= \Yii::t('common', 'Ngoài giúp bạn bán hàng, Vinagex còn giúp bạn giải quyết những khó khăn về kỹ thuật nông nghiệp') ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-section intro-2">
        <div class="container">
            <h3><?= \Yii::t('common', 'Cách thức tham gia và bán hàng trên Vinagex') ?></h3>
            <div class="sales-points">
                <div class="item">
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['seller/join']) ?>">
                        <div class="responsive-img">
                            <img alt="Đăng ký tham gia vào sàn" title="Đăng ký tài khoản bán hàng" src="/template/images/register.png" width="96" height="90">
                        </div>
                        <h4><?= \Yii::t('common', 'Đăng ký tham gia') ?></h4>
                        <p><?= \Yii::t('common', 'Điền thông tin vào biểu mẩu đăng ký. Chúng tôi sẽ xác thực thông tin của bạn và kích hoạt tài khoản bán hàng') ?></p>
                    </a>
                </div>
                <div class="item">
                    <a href="#">
                        <div class="responsive-img">
                            <img alt="Đăng sản phẩm lên hệ thống" title="Đăng sản phẩm lên hệ thống" src="/template/images/intro2.svg" width="96" height="90">
                        </div>
                        <h4><?= \Yii::t('common', 'Đăng bán sản phẩm') ?></h4>
                        <p><?= \Yii::t('common', 'Vào trang quản lý bán hàng của bạn để đăng sản phẩm. Chúng tôi sẽ xét duyệt sản phẩm của bạn trước khi hiển thị') ?></p>
                    </a>
                </div>
                <div class="item">
                    <a href="#">
                        <div class="responsive-img">
                            <img alt="Xử lý đơn hàng và tiến hành giao hàng" title="Xử lý đơn hàng và tiến hành giao hàng" src="/template/images/intro3.svg" width="96" height="90">
                        </div>
                        <h4><?= \Yii::t('common', 'Xử lý đơn hàng') ?></h4>
                        <p><?= \Yii::t('common', 'Khi nhận được đơn hàng bạn vào trang quản lý của mình để xác nhận giao hàng và tiến hành giao hàng như cam kết') ?></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-now">
        <div class="container">
            <div class="text"><img src="/template/images/contact-us.png" alt=""/><p><?= \Yii::t('common', 'Bạn cần giúp đỡ? Hãy gửi mail hoặc gọi cho chúng tôi (Hỗ trợ 24/7)') ?></p></div>
        </div>
    </div>
</div>

<?php ob_start(); ?>
<script>

    $('.fa-bars').click(function(){
        $('.navigation').toggle();
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>