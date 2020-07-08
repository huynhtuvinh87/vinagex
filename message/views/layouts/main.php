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
            'brandLabel' => '<img src="https://s3-ap-southeast-1.amazonaws.com/giataivuon/logo.png" width=200>',
            'brandUrl' => Yii::$app->setting->get('siteurl'),
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
        <!-- Firebase -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js'></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-database.js"></script>
        <script src='/lightbox/lightbox.js'></script>
        <script src= '/slick/slick.min.js'></script>
<!--        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-database.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-firestore.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-messaging.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-functions.js"></script>-->
        <!-- chat_realtime -->
        <script>
            var userInfo = {
                owner: '<?= Yii::$app->user->id ?>',
                link_cdn: "<?= Yii::$app->setting->get('siteurl_cdn') ?>",
                link_frontend: "<?= Yii::$app->setting->get('siteurl') ?>"
            }
            var apis = '/';
            var imageDir = 'image';
            var config = {
                apiKey: "<?= Yii::$app->setting->get('firebase_apikey') ?>",
                databaseURL: "<?= Yii::$app->setting->get('firebase_database_url') ?>",
            };
            firebase.initializeApp(config);
            var dbRef = firebase.database().ref(),
                    messageRef = dbRef.child('message'),
                    userRef = dbRef.child('user'),
                    countMsgRef = dbRef;
//I am doing a child based listener, but you can use .once('value')...

            $(function () {
<?php
if ($child) {
    ?>
                    var x = new Date(),
                            b = x.getDate(),
                            c = (x.getMonth() + 1),
                            d = x.getFullYear(),
                            e = x.getHours(),
                            f = x.getMinutes(),
                            g = x.getSeconds(),
                            date = d + '-' + (c < 10 ? '0' + c : c) + '-' + (b < 10 ? '0' + b : b) + ' ' + (e < 10 ? '0' + e : e) + ':' + (f < 10 ? '0' + f : f) + ':' + (g < 10 ? '0' + g : g);
                    var h = {
                        fullname: '<?= $child['actor']['fullname'] ?>',
                        avatar: '<?= $child['avatar'] ?>',
                        owner: '<?= $child['owner']['id'] ?>',
                        actor: '<?= $child['actor']['id'] ?>',
                        product_name: '<?= $child['product']['title'] ?>',
                        product_id: '<?= $child['product']['id'] ?>',
                        last_msg: "<?= trim($child['last_msg']) ?>",
                        login: date
                    };
                    userRef.push(h);
                    chat_realtime(userRef, messageRef, apis, '<?= $child['owner']['id'] ?>', '<?= $child['avatar'] ?>', imageDir, 'login', countMsgRef, userInfo);
    <?php
} else {
    ?>

                    //                    $('#chat-msg').hide();
                    //                    $('.product-info').hide();
                    //                    $('.checkout').hide();
                    //                    $('.chat-users').css('height', '100%');
                    chat_realtime(userRef, messageRef, apis, '<?= Yii::$app->user->id ?>', '', imageDir, 'success', countMsgRef, userInfo);
<?php } ?>

            });
        </script>
        <script type="text/javascript" src="/js/message.js"></script>
        <script type="text/javascript" src="/js/jquery.scrollbar.min.js"></script>
    </body>
</html>

<?php
$this->endPage();
exit;
?>