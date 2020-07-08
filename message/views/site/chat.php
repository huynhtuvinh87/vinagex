<?php

use yii\helpers\Html;
use yii\helpers\Json;
use common\components\Constant;
use frontend\storage\ProductItem;

if ($message->receive['id'] == Yii::$app->user->id) {
    $fullname = $message->sender['fullname'];
    $user_id = $message->sender['id'];
} else {
    $fullname = $message->receive['fullname'];
    $user_id = $message->receive['id'];
}

$this->title = $fullname;

$item = new ProductItem($product);
?>
<div class="wrap">
    <div class="container">
        <div class="row msg-tab">
            <div class="col-xs-6">
                <a href="javascript:void(0)" class="tab-msg btn btn-success">Tin nhắn</a>
            </div>
            <div class="col-xs-6">
                <a href="javascript:void(0)" class="tab-product btn btn-default">Sản phẩm</a>
            </div>
        </div>
    </div>
    <div class="col-left list-msg">
        <div class="header-list-message">
            <h4 style="text-align: center; margin: 0; padding-top: 15px">Tin nhắn</h4>
        </div>
        <ul class="list-group">
            <?php
            if (!empty($actor)) {
                foreach ($actor as $value) {
                    ?>
                    <li id="<?= $value['_id'] ?>" class="list-group-item <?= $_GET['id'] == $value['_id'] ? 'active' : '' ?>">
                        <a data-id="<?= $value['_id'] ?>" href="/site/chat/<?= $value['_id'] ?>">
                            <div class="media">
                                <div class="media-left">

                                    <img class="img-product" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value['avatar'] ?>&size=45x45">

                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?= ($message->receive['id'] == Yii::$app->user->id) ? $value['sender']['fullname'] : $value['receive']['fullname'] ?> <small>(<?= $value['product']['title'] ?>)</small></h4>
                                    <div class="last-msg" id="last-msg-<?= $value['_id'] ?>"><?= $value['last_msg'] ?></div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
    <div class="col-center list-conver">
        <div class="header-message-content">
            <a class="pull-right back" style="margin-top:15px; margin-right: 5px" href="javascript:void(0)">Quay lại</a></small><a href="<?= Yii::$app->setting->get('siteurl') ?>/user/view/<?= $user_id ?>" target="_blank"><h4 class="text-center"><?= $fullname ?></h4></a>
        </div>
        <div id="ms-content" class="content-message">
            <?php
            if (!empty($conversation)) {
                foreach ($conversation as $value) {
                    ?>
                    <div class="line <?= $value['sender']['id'] == Yii::$app->user->id ? "pull-right" : "pull-left" ?> clearfix">
                        <span><?= $value['message'] ?></span>
                    </div>
                    <?php
                }
            }
            ?>
            <div id="new-message-<?= $message->id ?>">
            </div>
        </div>
        <div class="box-footer" style="margin-top:20px">
            <div id="chatting">Đang trả lời ....</div>
            <?=
            Html::beginForm(['site/chat', 'id' => $message->id], 'POST', [
                'id' => 'chat-form'
            ])
            ?>
            <div class="input-group" style="width:100%; display: block">

                <?=
                Html::textInput('message', null, [
                    'id' => 'input-message',
                    'class' => 'form-control input-message',
                    'placeholder' => 'Nhập tin nhắn ...'
                ])
                ?>                
                <div class="input-group-btn">
                    <?=
                    Html::submitButton('Gửi', [
                        'class' => 'btn btn-block btn-success',
                        'style' => 'display:none'
                    ])
                    ?>                    
                </div>
            </div>
            <?= Html::endForm() ?> 
        </div>



    </div>
    <div class="col-right checkout">
        <h4 style="text-align: center; margin-right: -10px; margin-left: -10px; border-bottom: 1px solid #cdcd; margin-bottom: 20px; padding-bottom: 15px; margin-top: 5px">Thông tin sản phẩm</h4>
        <?php if (!empty($product['images'])) { ?>
            <div class="images-product">
                <div class="slider slider-single">
                    <?php foreach ($product['images'] as $key => $value) { ?>
                        <a class="lazyload <?= $key == 0 ? "" : "set-img" ?>" href="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . $value ?>" data-lightbox="roadtrip"><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . 'image.php?src=' . $value . '&size=400x300' ?>"></a>
                    <?php } ?>
                </div>
                <div class="slider slider-nav">
                    <?php foreach ($product['images'] as $value) { ?>
                        <a class="lazyload" href="javascript:void(0)"><img class="set-img" src="<?= Yii::$app->setting->get('siteurl_cdn') . '/' . 'image.php?src=' . $value . '&size=100x100' ?>"></a>
                    <?php } ?>
                </div>
            </div>
            <hr>
            <a target="_blank" href="<?= Yii::$app->setting->get('siteurl') ?>/<?= $product['slug'] . '-' . $product['id'] ?>" class="text-success"><h4><?= $product['title'] ?></h4></a>
        <?php } ?>
        <div class="product-price">
            <span class="orange"><?= $item->getPrice() ?> đ </span>/ <?= $product['unit'] ?>
        </div>
        <div class="sale-place"><img src="<?= Yii::$app->setting->get('siteurl') ?>/template/svg/location.svg" width="18"> <a class="text-dark" target="_blank" href="<?= Yii::$app->setting->get('siteurl') . '/nha-cung-cap/' . $product['owner']['username'] . '-' . $product['owner']['id'] ?>"><?= $item->getGardenname() ?></a> </div>
        <p class="minimum">
            Tối thiểu: <?= $item->getMinimum() ?> <?= $item->getUnit() ?>
        </p>
        <div class="buynow">
            <a target="_blank" href="<?= Yii::$app->setting->get('siteurl') ?>/<?= $product['slug'] . '-' . $product['id'] ?>" class="btn btn-success"><img src="<?= Yii::$app->setting->get('siteurl') ?>/template/svg/cart.svg" width="18"> Mua ngay</a>
            <p>Mua trực tiếp từ người bán</p>
        </div>
    </div>
</div>
<audio id="audio-<?= Yii::$app->user->id ?>" src="/audio/light.mp3"></audio>

<?php ob_start(); ?>
<script type="text/javascript">
    scrollBottom();
    $('.slider-single').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        asNavFor: '.slider-single',
        dots: true,
        centerMode: true,
        focusOnSelect: true
    });
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    });
    $("#chat-form").submit(function () {
        if ($("#input-message").val() != '') {
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $("#input-message").val('');
                }
            });
        }
        return false;
    });
    $('#input-message').focusin(function () {
        $.ajax({
            url: '/site/focus',
            type: "POST",
            data: "focus=in&message=" + "<?= $message->id ?>",
            success: function (data) {

            }
        });
        return false;
    });
    $('#input-message').focusout(function () {
        $.ajax({
            url: '/site/focus',
            type: "POST",
            data: "focus=out&message=" + "<?= $message->id ?>",
            success: function (data) {

            }
        });
        return false;
    });
    $(document).on('click', '.no-read a', function () {
        var url = $(this).attr('href');
        var id = $(this).attr('data-id');
        $.ajax({
            url: '/site/read',
            type: "POST",
            data: "id=" + id,
            success: function (data) {
                window.location.href = url;
            }
        });
    });
    $(document).ready(function () {


        var userid = '<?= Yii::$app->user->id ?>';//anything you like
        var room = '<?= $message->id ?>';//anything you like
        var socket = io.connect('vinagex.com:8890', {query: "userid=" + userid + "&room=" + room});
        socket.on('chat', function (data) {
            console.log('123455');
            var owner = '<?= Yii::$app->user->id ?>';
            $("#last-msg-" + data.message_id).html(data.message);
            var clone_elem = $('#' + data.message_id).clone();
            $('#' + data.message_id).remove();
            if (owner == data.sender) {
                $("#new-message-" + data.message_id).append('<div class="line pull-right clearfix"><span>' + data.message + '</span></div>');
            } else {
                $("#new-message-" + data.message_id).append('<div class="line pull-left clearfix"><span>' + data.message + '</span></div>');
                if (data.message_id != '<?= $_GET['id'] ?>') {
                    clone_elem.addClass('no-read');
                } else {
                    $.ajax({
                        url: '/site/read',
                        type: "POST",
                        data: "id=" + data.message_id,
                        success: function (data) {
                        }
                    });
                }
                document.getElementById("audio-" + data.receive).play();
            }
            $('ul.list-group').prepend(clone_elem);
            scrollBottom();
        });
        socket.on('focus', function (data) {
            if ('<?= $message->id ?>' == data.message_id) {
                if (data.message == 'in') {
                    $("#chatting").show();
                } else if (data.message == 'out') {
                    $("#chatting").hide();
                }
            }
        });
    });
    function scrollBottom() {
        var objDiv = document.getElementById("ms-content");
        objDiv.scrollTop = objDiv.scrollHeight;
    }

    $(function () {
        $(window).resize(function (e) {
            placeFooter();
        });
        placeFooter();
        scrollBottom();
        // hide it before it's positioned
//        $('#footer').css('display', 'inline');
    });
    function placeFooter() {
        var width = $(window).width();
        console.log(width);
        if (width == 360) {
            $('#ms-content').css('height', 412);
        } else if (width == 375) {
            $('#ms-content').css('height', 510);
        } else if (width == 411) {
            $('#ms-content').css('height', 510);
        } else if (width == 414) {
            $('#ms-content').css('height', 510);
        } else if (width == 768) {
            $('#ms-content').css('height', 600);
        } else {
            var height = $(window).height() - 175;
            $('#ms-content').css('height', height);
        }
    }
    $('body').on('click', '.tab-msg', function (e) {
        e.preventDefault();
        $(".list-msg").hide();
        $(".list-conver").show();
        $(".checkout").hide();
        $(".users-list").hide();
        $(".tab-product").removeClass("btn-success");
        $(".tab-product").addClass("btn-default");
        $(this).removeClass("btn-default");
        $(this).addClass("btn-success");
    });
    $('body').on('click', '.tab-product', function (e) {
        e.preventDefault();
        $(".list-msg").hide();
        $(".list-conver").hide();
        $(".checkout").show();
        $(".tab-msg").removeClass("btn-success");
        $(".tab-msg").addClass("btn-default");
        $(this).removeClass("btn-default");
        $(this).addClass("btn-success");
    });
    $('body').on('click', '.back', function (e) {
        e.preventDefault();
        $(".list-msg").show();
        $(".users-list").show();
        $(".list-conver").hide();
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>