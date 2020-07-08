<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\components\Constant;

frontend\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width">
        <?= Html::csrfMetaTags() ?>
        <link rel="icon" href="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/favico.ico" />
        <title><?= Html::encode($this->title) ?></title>
        <link rel="canonical" href="https://vinagex.com" />
        <meta property="og:locale" content="vi_VN" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?= Html::encode($this->title) ?>" />
        <meta property="og:url" content="https://vinagex.com" />
        <meta property="og:site_name" content="Sàn giao dịch nông sản" />
        <meta property="article:publisher" content="https://www.facebook.com/vinagex" />
        <?php $this->head() ?>
    </head>
    <body id="main">
        <?php $this->beginBody() ?>
        <div id="disabled"></div>
        <div id="wrapper">
            <header class="intro-header">
                <div class="top-bar">
                    <div class="container">
                        <div class="left">
                            <ul>
                                <li><a href="#"><?= \Yii::t('common', 'Kinh doanh thương mại điện tử cùng Vinagex') ?></a></li>
                            </ul>
                        </div>
                        <div class="right">
                            <ul>
                                <li>Email: <a href="#">support@vinagex.com</a></li>
                                <li>Hotline: <a href="#">0868.444.554</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="container">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                        <div class="left">
                            <div id="logo">
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/') ?>">
                                    <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png">
                                </a>
                            </div>
                        </div>

                        <nav class="navigation">
                            <ul class="main-menu">
                                <li><a href="#"><?= \Yii::t('common', 'Giới thiệu') ?></a></li>
                                <li><a href="#"><?= \Yii::t('common', 'Tìm hiểu chính sách') ?></a></li>
                                <li><a target="_blank" href="/huong-dan-dang-san-pham"><?= \Yii::t('common', 'Hướng dẫn đăng ký bán hàng') ?></a></li>
                            </ul>
                        </nav>
                        <div class="right">
                            <div class="button-block"><a href="<?= Yii::$app->user->isGuest ? Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_seller')) : Yii::$app->setting->get('siteurl_seller') ?>" class="btn btn-custom"><?= \Yii::t('common', 'Đăng ký bán hàng') ?></a></div>
                        </div>
                    </div>
                </div>
            </header>

            <div id="content">
                <?= $content ?>
            </div>
        </main>

        <?= \frontend\widgets\FooterWidget::widget(['layout' => 'seller_about']) ?>
    </div>

    <?php $this->endBody() ?>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat"
         attribution=setup_tool
         page_id="298064967667243"
         logged_in_greeting="Chào bạn! Chúng tôi có thể giúp được gì cho bạn?"
         logged_out_greeting="Chào bạn! Chúng tôi có thể giúp được gì cho bạn?">
    </div>
</body>
</html>
<?php $this->endPage() ?>

