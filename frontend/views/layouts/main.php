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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            .modal-open .select2-container--open { z-index: 999999 !important; width:100% !important; }
        </style>
    </head>
    <body class="page-<?= Yii::$app->controller->id ?>">
        <?php $this->beginBody() ?>
        <div id="disabled"></div>
        <div id="wrapper">
            <?= frontend\widgets\HeaderWidget::widget() ?>
            <main>
                <div class="container">
                    <?=
                    Breadcrumbs::widget([
                        'homeLink' => ['label' => \Yii::t('common', 'Trang chủ')],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]);
                    ?>
                </div>
                <?= $content ?>
            </main>
            <?= \frontend\widgets\FooterWidget::widget(['layout' => 'main']) ?>
        </div>
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

            $(".close-menu").on("mouseleave", function () {
                console.log('12');
            });
            var config = {
                apiKey: "<?= Yii::$app->setting->get('firebase_apikey') ?>",
                databaseURL: "<?= Yii::$app->setting->get('firebase_database_url') ?>",
            };
            firebase.initializeApp(config);
            var dbRef = firebase.database().ref(),
                    messageRef = dbRef.child('message'),
                    userRef = dbRef.child('user'),
                    countMsgRef = dbRef.child('countmsg_customer_<?= Yii::$app->user->id ?>');

            countMsgRef.on('value', function (snapshot) {

                snapshot.forEach(function (item) {
                    $('.countMsg').hide();
                    if (item.val().count > 0) {
                        $('.countMsg').show();
                        $('.countMsg').html(item.val().count);
                    }
                })

            });
            $('.select2-select').select2({

            });
            $('.select2-no-search').select2({

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
            //mobile
            if ($(window).width() <= 736) {
                $('.sb-section.detail-company:nth-child(1)').detach().appendTo('.product-detail-inner');
                $('.alert-info').detach().appendTo('form.cart');

                $('.footer-top .widget-title').on('click', function () {
                    if ($(this).hasClass('expanded')) {
                        $(this).removeClass('expanded');
                        $(this).siblings('.textwidget').removeClass('expanded');
                    } else {
                        $(this).addClass('expanded');
                        $(this).siblings('.textwidget').addClass('expanded');
                    }
                });
                $('.company-section table').parent('.comp-content').addClass('table-responsive');
                //sticky header
                $(window).scroll(function () {
                    var sticky = $('header');
                    var scroll = $(window).scrollTop(),
                            height = 80;
                    if (scroll > height) {
                        sticky.addClass('sticky-header');
                        $("#search_form").addClass('hidden');
                        if ($(window).width() <= 600) {
                            $(".nav-down").css('top', 0);
                        } else {
                            if ($('#wpadminbar').height() > 0) {
                                $('.nav-down').css('top', $('#wpadminbar').height());
                            } else {
                                $('.nav-down').css('top', 0);
                            }
                        }
                    } else {
                        sticky.removeClass('sticky-header');
                        $("#search_form").removeClass('hidden').removeAttr("style");
                        ;
                    }
                });
                $('.icon-search').on('click', function () {
                    $("#search_form").removeClass('hidden');
                    $("#search_form").slideToggle();
                });
                // Hide Header on on scroll down menu
                var didScroll;
                var lastScrollTop = 0;
                var delta = 5;
                var navbarHeight = $('header').outerHeight();
                $(window).scroll(function (event) {
                    didScroll = true;
                });
                setInterval(function () {
                    if (didScroll) {
                        hasScrolled();
                        didScroll = false;
                    }
                }, 1000);

                function hasScrolled() {
                    var st = $(this).scrollTop();
                    console.log(st);
                    var scroll = $(window).scrollTop(),
                            height = 250;
                    // Make sure they scroll more than delta
                    if (Math.abs(lastScrollTop - st) <= delta)
                        return;
                    // If they scrolled down and are past the navbar, add class .nav-up.
                    // This is necessary so you never see what is "behind" the navbar.
                    if (st > lastScrollTop && st > navbarHeight) {
                        // Scroll Down
                        $('header').removeClass('nav-down').addClass('nav-up').removeAttr("style");
                    } else {
                        // Scroll Up
                        if (st + $(window).height() < $(document).height()) {
                            if (st > height) {
                                $('header').removeClass('nav-up').addClass('nav-down');
                            } else {
                                $('header').removeClass('nav-up').removeClass('nav-down').removeAttr("style");
                            }
                        }
                    }
                    lastScrollTop = st;
                }
            }

            $(document).ready(function () {
                $('.page-seller .menu-seller .btn-menu').on('click', function () {
                    $('.page-seller .menu-seller .list-menu').toggle();
                });
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
    <script>
      var URL_SERVER = 'https://vinagex.com:8890';
      var socket = io.connect(URL_SERVER);

      socket.on('message', function() {
        console.log('Messages');
      });
    </script>
    </body>
</html>
<?php $this->endPage() ?>
