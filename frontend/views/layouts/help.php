<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\components\Constant;
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
                                <li><a href="#">Kinh doanh thương mại điện tử cùng Vinagex</a></li>
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
                                    <img style="width: 175px; padding-right: 44px;" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/images/logo_beta.png">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </header>

            <div id="content">

                <div class="banner-search">
                    <div class="container">
                        <h2>Xin chào. Chúng tôi có thể giúp gì cho bạn?</h2>

                    </div>
                </div>

                <div class="container">
                    <?=
                    Breadcrumbs::widget([
                        'homeLink' => ['label' => 'Trang chủ'],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]);
                    ?>
                    <div style="margin-top: 20px;" class="row">
                        <div class="col-xs-3">
                            <?= \frontend\widgets\SidebarWidget::widget() ?>
                        </div>
                        <div class="col-xs-9">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?= \frontend\widgets\FooterWidget::widget(['layout' => 'seller_about']) ?>
    </div>

    <?php $this->endBody() ?>
    <?php ob_start(); ?>

    <script>
        $('.btn-help').click(function () {
            $('.list-help').toggle();
        });
    </script>

    <?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
</body>
</html>
<?php $this->endPage() ?>

