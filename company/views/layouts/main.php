<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use company\assets\CompanyAsset;
use yii\helpers\Url;

CompanyAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link rel="icon" href="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/favico.ico" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="logo">
                            <a href="<?= Yii::$app->setting->get('siteurl') ?>"><img width="225" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png"></a>
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-6">
                        <div class="pull-right">
                            <?= Html::a(Yii::t('common', 'Trang chủ'), Yii::$app->homeUrl); ?>
                            <div class="dropdown show language">
                                <a class="dropdown-toggle language-bar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="language-name"><?= \Yii::t("common", "Ngôn ngữ") ?></span> <span class="lang-sm" lang="<?= Yii::$app->language ?>"></span>
                                </a>
                                <ul class="dropdown-menu dropdown">
                                    <li><?= Html::a('<span class="lang-sm lang-lbl-full" lang="vi"></span>', Url::current(['lang' => 'vi'])) ?></li> 
                                    <li><?= Html::a('<span class="lang-sm lang-lbl-full" lang="en"></span>', Url::current(['lang' => 'en'])) ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <?= $content ?>
        </div>
        <?= frontend\widgets\FooterWidget::widget() ?>
        <?php $this->endBody() ?>

        <script>
            $(document).ready(function (e) {
                $('.search-panel .dropdown-menu').find('a').click(function (e) {
                    e.preventDefault();
                    var param = $(this).attr("href").replace("#", "");
                    var concept = $(this).text();
                    $('.search-panel span#search_concept').text(concept);
                    $('.input-group #search_param').val(param);
                    $("#formSearch").submit();
                });
            });
        </script>
    </body>
</html>
<?php
$this->endPage();
?>
                        

