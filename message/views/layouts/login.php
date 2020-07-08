<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use seller\assets\SellerAsset;
use common\widgets\Alert;
use \common\components\Constant;

SellerAsset::register($this);
$cookies = Yii::$app->request->cookies;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <?php
        NavBar::begin([
            'brandLabel' => 'Giataivuon.com',
            'brandUrl' => Yii::$app->homeUrl,
            'innerContainerOptions' => ['class' => 'container-fluid'],
            'options' => [
            ],
        ]);
        $menuItems = [
            ['label' => 'Trang chủ', 'url' => ['site/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Đăng ký', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Đăng nhập', 'url' => ['/site/login']];
        } else {
            $menuItems[] = ['label' => 'Quản lý sản phẩm', 'url' => ['/product/index']];
            $menuItems[] = ['label' => 'Chào ' . Yii::$app->user->identity->fullname, 'url' => ['/seller/update']];
            $menuItems[] = '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                            'Thoát', ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>';
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class=" container-fluid" style="min-height:1000px;">
            <?= $content ?>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
        <script>
            $(function () {
                $('.datepicker').datepicker({
                    monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    autoclose: true,
                    startDate: new Date(),
                    todayHighlight: true,
                    language: 'vi-VN'
                });

            });

            $(document).ready(function () {

                $('.select2-select').select2({

                })

            });

        </script>

    </body>
</html>
<?php $this->endPage() ?>
