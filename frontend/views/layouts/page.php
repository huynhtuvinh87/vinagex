<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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
                       <!--  <i class="fa fa-bars" aria-hidden="true"></i> -->
                        <div class="left">
                            <div id="logo">
                                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/') ?>">
                                    <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </header>

            <div id="content">

                <div class="banner-search">
                    <div class="container">
                        <h2><?= Yii::t('common', 'Trung tâm hỗ trợ Vinagex') ?></h2>

                    </div>
                </div>

                <div style="min-height: 650px" class="container">
                    <?=
                    Breadcrumbs::widget([
                        'homeLink' => ['label' => \Yii::t('common', 'Trang chủ')],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]);
                    ?>
                    <div style="margin-top: 20px;" class="row">
                        <div class="col-sm-3">
                            <?= \frontend\widgets\SidebarPageWidget::widget() ?>
                        </div>
                        <div style="border-left: 1px solid #EEEEEE" class="col-sm-9">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?= \frontend\widgets\FooterWidget::widget(['layout' => 'seller_about']) ?>
    </div>

    <?php $this->endBody() ?>

    <script>
        $('.btn-help').click(function () {
            $('.list-help').toggle();
        });
    </script>
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

