<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

$child = Yii::$app->helper->childadded();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <!-- chat_realtime -->
        <link href="/css/jquery.scrollbar.css" rel="stylesheet">
        <link href="/css/message.css" rel="stylesheet">
        <link href='/lightbox/lightbox.css' rel="stylesheet">
        <link href='/slick/slick.css' rel="stylesheet">

    </head>
    <body>
        <?php $this->beginBody() ?>
        <?php
        NavBar::begin([
            'brandLabel' => '<img src="https://cdn.vinagex.com/main/logo.png" width=180 style="margin-top:5px;">',
            'brandUrl' => Yii::$app->params['frontend'],
            'innerContainerOptions' => ['class' => 'container'],
            'options' => [
            ],
        ]);
        $menuItems = [
            ['label' => 'Trang chủ', 'url' => Yii::$app->setting->get('siteurl')],
            ['label' => 'Bán hàng cùng vinagex', 'url' => Yii::$app->setting->get('siteurl_seller')],
            ['label' => 'Xin chào ' . Yii::$app->user->identity->fullname, 'url' => ['#']],
        ];

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container-full">
            <?= $content ?>
        </div>
        <?php $this->endBody() ?>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js'></script>
        <script src='/lightbox/lightbox.js'></script>
        <script src= '/slick/slick.min.js'></script>
        <script type="text/javascript" src="/js/message.js"></script>
        <script type="text/javascript" src="/js/jquery.scrollbar.min.js"></script>
    </body>
</html>

<?php
$this->endPage();
exit;
?>