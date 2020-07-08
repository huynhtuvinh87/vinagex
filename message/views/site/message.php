<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use common\components\Constant;

$this->title = 'Nền tảng bán hàng dành cho nhà vườn';
$user = Yii::$app->session['login'];
?>
<div id="chat-realtime">
    <div class="row msg-tab">
        <div class="col-xs-6">
            <a href="javascript:void(0)" class="tab-msg btn btn-success">Tin nhắn</a>
        </div>
        <div class="col-xs-6">
            <a href="javascript:void(0)" class="tab-product btn btn-default">Sản phẩm</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 list-msg">
            <h4>Danh sách tin nhắn </h4>
            <hr style="margin: 10px 0; height: 1px; margin-left: -15px; width: 116%">
            <ul class="users-list">
                <?php
                if (!empty($actor)) {
                    foreach ($actor as $value) {
                        ?>
                        <li id="product_<?= $value['owner']['id'] ?>_<?= $value['product']['id'] ?>" class="bounceInDown <?= $value['_id'] == $message->id ? "active" : "" ?> msg" data-actor="<?= $value['owner']['id'] ?>" data-pid="<?= $value['product']['id'] ?>">
                            <a href="/message/<?= $value['_id'] ?>" class="clearfix">	
                                <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value['avatar'] ?>&size=45x45">	
                                <div class="users-name">	
                                    <strong><?= $value['product']['title'] ?></strong>	
                                </div>		
                                <div class="last-message msg">
                                    <?= $value['last_msg'] ?>
                                </div>		
                                <small class="time text-muted"><?= Constant::time(strtotime($value['last_msg_time'])) ?></small>
                                <small class="chat-alert label label-primary">0</small>
                                <small class="user"><?= $value['owner']['fullname'] ?></small>	</a>
                        </li>
                        <?php
                    }
                }
                ?>

            </ul>

        </div>
        <!-- rooms list -->
        <div class="col-sm-6 list-conver">
            <div class="chat-container">
                <div class="chat-header">
                    <h4><?= $message['owner']['fullname'] ?> <small><a class="pull-right back" href="javascript:void(0)">Quay lại</a></small></h4>

                </div>
                <ul class="chat chat-users">
                    <?php
                    if (!empty($conversation)) {
                        foreach ($conversation as $value) {
                            ?>
                            <li class="<?= $value['owner'] == Yii::$app->user->id ? "right" : "left" ?>">
                                <?php
                                if ($value['owner'] != Yii::$app->user->id) {
                                    ?>
                                    <span class="chat-img pull-left">
                                        <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value['avatar'] ?>&size=45x45">
                                    </span>
                                    <?php
                                }
                                ?>
                                <div class="chat-body clearfix">
                                    <p class="msg"><?= $value['message'] ?></p>
                                    <small><i class="fa fa-clock-o"></i> <?= Constant::time(strtotime($value['date'])) ?></small>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <div class="chat-box">
                    <input type="hidden" id="conversation_actor" value="<?= $message['owner']['id'] ?>">
                    <input type="hidden" id="conversation_product_id"  value="<?= $message['product']['id'] ?>">
                    <form id="chat-msg" class="chat-msg">
                        <div class="form-group">
                            <textarea id="message" type="text" class="form-control border no-shadow no-rounded" style="border: 0;"  placeholder="Nhập nội dung..."></textarea>
                        </div>
                        <div id="reviewImg" style="padding: 0 10px"></div>
                        <div>										
                            <!--                            <label class="pull-left btn btn-primary" for="fileinput">
                                                            <input type="file" id="fileinput" multiple style="display: none;">Tải hình ảnh
                                                        </label>		-->
                            <button class="btn btn-success pull-right" id="send" type="submit">Gửi</button>
                        </div>
                        <p class="help-block-error pull-right text-danger" style="padding-right: 10px"></p>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-sm-3 checkout">
            <div class="product-info" id="product-info">
                <div class="product-des">
                    <div class="media">
                        <div class="media-left">
                            <a target="_blank" href="' + link + '">
                                <img class="media-object img-thumbnail" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $product->images[0] ?>&size=100x100"></a>
                        </div>
                        <div class="media-body">
                            <a target="_blank" href="<?= Yii::$app->setting->get('siteurl') . '/' . $product->slug . '-' . $product->id ?>">
                                <h4 class="media-heading"><?= $product->title ?></h4>
                            </a>
                            <p><a target="_blank" class="btn btn-success" href="<?= Yii::$app->setting->get('siteurl') . '/' . $product->slug . '-' . $product->id ?>">Đặt hàng</a></p>
                            <?php
                            if ($product->price['min'] == $product->price['max']) {
                                $price = Constant::price($product->price['min']);
                            } else {
                                $price = Constant::price($product->price['min']) . ' - ' . Constant::price($product->price['max']);
                            }
                            ?>

                        </div>
                    </div>
                    <dl class="dl-horizontal" style="margin-top:20px">
                        <dt>Tên sản phẩm</dt><dd><?= $product->title ?></dd>
                        <dt>Giá sản phẩm</dt><dd><?= $price ?> đ</dd>
                        <dt>Mô tả sản phẩm</dt><dd><?= $product->content ?></dd>
                    </dl>
                </div>
                <div class="seller">

                </div>
            </div>

        </div>
    </div>
</div>
<?php ob_start(); ?>

<script type="text/javascript">

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
    $(document).ready(function () {
        $('.scrollbar-inner').scrollbar();
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>