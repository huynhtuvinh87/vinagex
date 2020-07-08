<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
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
        <link rel="icon" href="https://cdn.vinagex.com/main/favico.ico" />
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
            #approx-list > div:after{
                border-bottom: 1px solid #ddd;
                padding: 10px;
                width: 100%;
                width: 97.5%;
                margin-left: 15px;
            }
        </style>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?= seller\widgets\HeaderWidget::widget() ?>

        <div class="container-fluid wrapper">
            <div class="pull-left">
                <?=
                Breadcrumbs::widget([
                    'homeLink' => ['label' => 'Trang chủ', 'url' => '/'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                ?>
            </div>
            <div class="pull-right btn-add-product"><a href="/product/create" class="btn btn-success" role="button">Thêm sản phẩm</a></div>
            <div style="clear: both;"></div>
            <div class="row">
                <div class="col-sm-12">
                    <a href="javascript:void(0)" class="btn btn-default btn-category" style="margin-bottom:10px"><i class="fa fa-align-justify"></i> Danh mục quản lý</a>
                </div>
                <div class="col-sm-2 sidebar">
                    <?= seller\widgets\SidebarWidget::widget() ?>
                </div>
                <div class="col-sm-10 content">

                    <?php
                    $noti = [];
                    if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->status == \common\components\Constant::STATUS_NOACTIVE) {
                        $noti[] = '<a href="/seller/index"><strong>thông tin tài khoản bán hàng</strong></a>';
                    }
                    if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->payment) {
                        $noti[] = '<a href="/payment"><strong>thông tin thanh toán</strong></a>';
                    }
                    if (!empty($noti)) {
                        ?>
                        <div class="alert-warning alert">
                            <p>
                                Chú ý: Bạn chưa cập nhật đầy đủ: <?= implode(' và', $noti) ?>
                            </p>
                        </div>
                        <?php
                    }

                    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->public == 2) {
                        if (!empty(Yii::$app->user->identity->reason)) {
                            ?>
                            <div id="w1-user-active" class="alert-warning alert fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <p>Rất tiết, tài khoản của bạn bị từ chối duyệt. Hãy xem lý do bên dưới và 
                                    <a style="background: #FF9800;padding: 5px; border-radius: 5px;color: #fff;" href="/seller/index">Cập nhật thông tin</a>. 
                                    <b>Đừng lo!</b> Chúng tôi sẽ xem xét và duyệt lại sau khi bạn cập nhật thông tin chính xác.</p>
                                <p><b>Lý do:</b></p>
                                <?php
                                foreach (Yii::$app->user->identity->reason as $value) {
                                    ?>
                                    <p> - <?= $value ?></p>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                    } else if (!Yii::$app->user->isGuest && Yii::$app->user->identity->public == 2) {
                        ?> 
                        <div id="w1-user-active" class="alert-warning alert fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p>Tài khoản của bạn đang chờ duyệt. Xin vui lòng đợi!</p>
                        </div>
                        <?php
                    }
                    ?>
                    <?= Alert::widget() ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title"><?= $this->title ?></h3></div>
                        <div class="panel-body">
                            <?= $content ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?= seller\widgets\FooterWidget::widget() ?>


        <?php $this->endBody() ?>

        <script>
//            $('body').on('keypress', '.price', function (e) {
//                if (!$.isNumeric(String.fromCharCode(e.which)))
//                    e.preventDefault();
//            });
//            $('body').on('paste', '.price', function (e) {
//                var cb = e.originalEvent.clipboardData || window.clipboardData;
//                if (!$.isNumeric(cb.getData('text')))
//                    e.preventDefault();
//            });
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
            function formatPrice(num) {
                var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
                if (str.indexOf(".") > 0) {
                    parts = str.split(".");
                    str = parts[0];
                }
                str = str.split("").reverse();
                for (var j = 0, len = str.length; j < len; j++) {
                    if (str[j] != ",") {
                        output.push(str[j]);
                        if (i % 3 == 0 && j < (len - 1)) {
                            output.push(",");
                        }
                        i++;
                    }
                }
                formatted = output.reverse().join("");
                return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
            }
//            $("body").on('keyup', '.price', function (e) {
//                $(this).val(formatPrice($(this).val()));
//            });

            window.addEventListener("load", function (event) {
                lazyload();
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
