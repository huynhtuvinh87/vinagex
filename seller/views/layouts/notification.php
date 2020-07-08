<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use seller\assets\SellerAsset;
use common\widgets\Alert;

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
        <style type="text/css">
            .navbar-brand{
                padding: 2px 15px;
            }
            .btn-add-product{
                padding: 8px 0 8px 0;
            }
            .loader {
                border: 8px solid #f3f3f3;
                border-radius: 50%;
                border-top: 8px solid #52af50;
                width: 60px;
                height: 60px;
                -webkit-animation: spin 2s linear infinite; /* Safari */
                animation: spin 2s linear infinite;
                margin: 30% auto
            }

            /* Safari */
            @-webkit-keyframes spin {
                0% { -webkit-transform: rotate(0deg); }
                100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

        </style>
    </head>
    <body class="page-<?= Yii::$app->controller->id ?>">
        <?php $this->beginBody() ?>
        <?php
        NavBar::begin([
            'brandLabel' => '<img src="' . Yii::$app->setting->get('siteurl_cdn') . '/images/logo_beta.png" width=125>',
            'brandUrl' => Yii::$app->setting->get('siteurl'),
            'innerContainerOptions' => ['class' => 'container-fluid'],
            'options' => [
                'id' => 'navbar-seller',
            ],
        ]);
        $menuItems = [
            ['label' => 'Trang chủ', 'url' => ['site/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Đăng ký', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Đăng nhập', 'url' => ['/site/login']];
        } else {
            $menuItems[] = ['label' => 'Hộp thư <span id="msg" class="badge"></span>', 'url' => Yii::$app->setting->get('siteurl_message'), 'linkOptions' => ['target' => '_blank']];
            $menuItems[] = ['label' => 'Thông báo (10) ', 'url' => ['/notification']];
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
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right navbar-menu'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>

        <div class="container-fluid wrapper">
             <?= $content ?>
        </div>
        <?= seller\widgets\FooterWidget::widget() ?>


        <?php $this->endBody() ?>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-auth.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-database.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-firestore.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-messaging.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.13.0/firebase-functions.js"></script>
        <script>
            window.addEventListener("load", function (event) {
                lazyload();
            });
            var config = {
                apiKey: "<?= Yii::$app->setting->get('firebase_apikey') ?>",
                databaseURL: "<?= Yii::$app->setting->get('firebase_database_url') ?>",
            };
            firebase.initializeApp(config);
            var dbRef = firebase.database().ref(),
                    messageRef = dbRef.child('message'),
                    userRef = dbRef.child('user'),
                    countMsgRef = dbRef.child('countmsg_seller_<?= Yii::$app->user->id ?>');

            countMsgRef.on('value', function (snapshot) {
                snapshot.forEach(function (item) {
                    $('#msg').hide();
                    if (item.val().count > 0) {
                        $('#msg').show();
                        $('#msg').html(item.val().count);
                    }
                })

            });
            function searchFilter() {
                // Declare variables
                var input, filter, ul, li, a, i;
                input = document.getElementById('search-filter');
                filter = input.value.toUpperCase();
                ul = document.getElementById("myUL");
                li = ul.getElementsByTagName('li');

                // Loop through all list items, and hide those who don't match the search query
                for (i = 0; i < li.length; i++) {
                    a = li[i].getElementsByTagName("a")[0];
                    if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                    } else {
                        li[i].style.display = "none";
                    }
                }
            }
            function handleFileSelect() {
                //Check File API support
                if (window.File && window.FileList && window.FileReader) {

                    var files = event.target.files; //FileList object
                    var output = document.getElementById("result");

                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        //Only pics
                        if (!file.type.match('image'))
                            continue;

                        var picReader = new FileReader();
                        picReader.addEventListener("load", function (event) {
                            var picFile = event.target;
                            var div = document.createElement("div");
                            div.className = 'col-sm-3 img-item';
                            div.innerHTML = "<div class='img_view'><img src='" + picFile.result + "' style='width:100%;'/></div><a href='javascript:void(0)' class='btn btn-danger'>Xoá</a>";
                            output.insertBefore(div, null);
                        });
                        //Read the image
                        picReader.readAsDataURL(file);
                    }
                } else {
                    console.log("Your browser does not support File API");
                }
            }

            function uploadProduct() {
                $('#submit-product-form').removeAttr('disabled');
                //Check File API support
                if (window.File && window.FileList && window.FileReader) {

                    var files = event.target.files; //FileList object
                    var output = document.getElementById("result");

                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        //Only pics
                        if (!file.type.match('image'))
                            continue;

                        var picReader = new FileReader();
                        picReader.addEventListener("load", function (event) {
                            var picFile = event.target;
                            var div = document.createElement("div");
                            div.className = 'col-sm-3 img-item';
                            div.innerHTML = "<div class='img_view'><img class='img-thumbnail' src='" + picFile.result + "' style='width:100%; height:190px'/></div><a href='javascript:void(0)' class='btn btn-danger'>Xoá</a>";
                            output.insertBefore(div, null);
                        });
                        //Read the image
                        picReader.readAsDataURL(file);
                    }
                } else {
                    console.log("Your browser does not support File API");
                }
            }


            $(document).on('click', '.btn-category', function () {
                $(".sidebar").toggle();
            });
//            $(".btn-category").on("mouseleave", function () {
//                $(".sidebar").hide();
//            });
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


            function CountDownTimer(dt, id)
            {
                var end = new Date(dt);

                var _second = 1000;
                var _minute = _second * 60;
                var _hour = _minute * 60;
                var _day = _hour * 24;
                var timer;
                function showRemaining() {
                    var now = new Date();
                    var distance = end - now;
                    if (distance < 0) {

                        clearInterval(timer);
                        document.getElementById(id).innerHTML = 'Hết hạn';

                        return;
                    }
                    var days = Math.floor(distance / _day);
                    var hours = Math.floor((distance % _day) / _hour);
                    var minutes = Math.floor((distance % _hour) / _minute);
                    var seconds = Math.floor((distance % _minute) / _second);

                    document.getElementById(id).innerHTML = days + ' ngày ';
                    document.getElementById(id).innerHTML += hours + ': ';
                    document.getElementById(id).innerHTML += minutes + ': ';
                    document.getElementById(id).innerHTML += seconds;
                }

                timer = setInterval(showRemaining, 1000);
            }
            $(document).ready(function () {

                $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $(".get-a-quote").click(function () {
                    $("#get-a-quote").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                });
                $('.select2-select').select2({

                })

            });

            jQuery(function ($) {
                $.datepicker.regional['vi'] = {
                    closeText: 'Đóng',
                    prevText: '&#x3c;Trước',
                    nextText: 'Tiếp&#x3e;',
                    currentText: 'Hôm nay',
                    monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
                        'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
                    monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                        'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
                    dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    weekHeader: 'Tu',
                    dateFormat: 'dd/mm/yy',
                    firstDay: 0,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''};
                $.datepicker.setDefaults($.datepicker.regional['vi']);
            });

            $.fn.datetimepicker.dates['vi'] = {
                days: ["Chủ nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
                daysShort: ["CN", "T2", "T3", "T4", "T5", "T6", "T7", "CN"],
                daysMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7", "CN"],
                months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                monthsShort: ["Thg1", "Thg2", "Thg3", "Thg4", "Thg5", "Thg6", "Thg7", "Thg8", "Thg9", "Thg10", "Thg11", "Thg12"],
                meridiem: '',
                today: "Hôm nay"
            };

        </script>
    </body>
</html>
<?php $this->endPage() ?>
