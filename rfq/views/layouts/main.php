<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use rfq\assets\RfqAsset;

RfqAsset::register($this);
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
        <?= rfq\widgets\HeaderWidget::widget() ?>
        <div class="wrapper" style="min-height: 900px">
            <?= $content ?>
        </div>
        <footer>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 copyright">
                            <div class="pull-left">
                                <ul>
                                    <li><a class="text-success" href="/help/join"><?= \Yii::t('rfq', 'Trung tâm hỗ trợ'); ?></a></li>
                                    <li><?= \Yii::t('rfq', 'Điện thoại hỗ trợ'); ?>: 0843.286.386</li>
                                    <li>Email: <a href="javascript:void(0)" class="text-success">hotro@vinagex.com</a></li>
                                </ul>
                            </div>
                            <div style="line-height: 50px" class="pull-right">
                                Vinagex 2018. All rights reserved
                            </div>
                        </div>
                        <div class="col-sm-2 icon">
                           <!--  <a href="#"><img src="/template/images/logo-dangky.png" alt=""></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <?php $this->endBody() ?>


        <?php ob_start(); ?>
        <script>
            $(document).on('click', '.item-category', function () {
                $('.title-category').html($(this).html() + ' <span class="caret"></span>');
                $('#search_category').val($(this).attr('data-category'));
                $('.text-search').attr('placeholder', '<?= Yii::t('rfq', 'Tìm kiếm') ?>: ' + $(this).html() + ' ...');
            });
            $(document).on('click', '#item-logout', function () {
                $('#logout').submit();
            });
            $("body").on("click", ".media-heading a, .media-left a", function () {
                window.location.href = $(this).attr("href");
            });
            if ($(window).width() <= 736) {
                $('.form-search-mobile').html($('.form-search-desktop').html());
                $('.form-search-desktop').html("");
            } else {
                if ($('.form-search-mobile').text() === "") {
                    $('.form-search-desktop').html($('.form-search-mobile').html());
                    $('.form-search-mobile').html("");
                }
            }
        </script>
        <?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
    </body>
</html>
<?php
$this->endPage();
?>
                        

