<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

frontend\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <style>
            .profiles{
                margin-bottom: 20px;
            }
            .profiles img{
                float: left;
                width: 50px;
                margin-right: 10px
            }
        </style>
    </head>
    <body class="page-<?= Yii::$app->controller->id ?>">
        <?php $this->beginBody() ?>
        <?= \frontend\widgets\HeaderWidget::widget() ?>
        <div id="disabled"></div>
        <div id="content">
            <div class="container container-mobile">
                <?=
                Breadcrumbs::widget([
                    'homeLink' => ['label' => \Yii::t('common', 'Trang chủ')],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                ?>
                <?= Alert::widget() ?>
                <div class="row">
                    <div class="col-sm-3">

                        <div class="profiles">
                            <img src="<?= !empty(Yii::$app->user->identity->avatar) ? Yii::$app->params['cdn'] . 'image.php?src=' . Yii::$app->user->identity->avatar . '&size=35x35' : "/template/svg/user-black.svg" ?>"> 
                            <span>
                                <?= \Yii::t('common', 'Chào {username}', ['username' => '<b>' . Yii::$app->user->identity->fullname . '</b>']) ?><br>
                                <?= \Yii::t('common', 'Tài khoản'); ?>
                            </span>
                        </div>
                        <a class="btn btn-default profile-btn"><?= \Yii::t('common', 'Danh mục') ?></a>

                        <div class="panel panel-default panel-profile">
                            <ul class="list-group list-profile">
                                <li class="list-group-item"><a href="/thong-tin-tai-khoan"><?= \Yii::t('common', 'Thông tin cá nhân'); ?></a></li>
                                <li class="list-group-item"><a href="/quan-ly-don-hang"><?= \Yii::t('common', 'Quản lý đơn hàng'); ?></a></li>
                                <li class="list-group-item"><?= Html::a(\Yii::t('common', 'Quản lý báo giá'), Yii::$app->params['rfq'] . 'manager/rfq'); ?></li>
                                <li class="list-group-item"><a href="/san-pham-yeu-thich"><?= \Yii::t('common', 'Sản phẩm yêu thích'); ?></a></li>
                                <li class="list-group-item"><a href="/nha-vuon-ban-quan-tam"><?= \Yii::t('common', 'Nhà vườn đã quan tâm'); ?></a></li>
                                <li class="list-group-item"><a href="<?= Yii::$app->params['message'] ?>"><?= \Yii::t('common', 'Hộp thư của bạn'); ?> <span class="badge countMsg"></span></a></li>
                                <li class="list-group-item"><a href="/user/password"><?= \Yii::t('common', 'Thay đổi mật khẩu'); ?></a></li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-sm-9">
                        <?= $content ?>
                    </div>
                </div>

            </div>
        </div>

        <?= \frontend\widgets\FooterWidget::widget(['layout' => 'main']) ?>

        <?php $this->endBody() ?>
        <script>
            window.addEventListener("load", function (event) {
                lazyload();
            });
            $(document).ready(function () {
                $('.profile-btn').click(function () {
                    $('.panel-profile').toggle();
                });
                $('.select2-select').select2({

                })

            });
        </script>

    </body>
</html>
<?php $this->endPage() ?>
