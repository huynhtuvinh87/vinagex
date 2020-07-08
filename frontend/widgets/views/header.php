<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\Html;
use yii\helpers\Url;
use common\components\Constant;

$cart = Yii::$app->cart;
?>
<header>
    <div class="top-bar">
        <div class="container container-mobile">
            <div class="left">
                <div class="provinces-box provinces-header">
                    <a><i class="fas fa-map-marker-alt"></i> <?= \Yii::t('frontend', 'Xem bán, giao hàng tại:'); ?></a>
                    <span><?= \Yii::t('frontend', 'Toàn quốc'); ?></span>
                    <div class="fake"></div>
                    <div class="balloon">
                        <div class="point"></div>
                        <span class="close">╳</span>
                        <span><?= \Yii::t('frontend', 'Chọn tỉnh thành để xem giá & giao hàng tại'); ?>:</span>
                        <input type="text" class="search-province" placeholder="<?= \Yii::t('frontend', 'Tìm kiếm tỉnh thành...'); ?>">
                        <ul>
                            <?php
                            foreach ($province as $value) {
                                if (Yii::$app->province->getId() == $value->id) {
                                    echo '<li class="active"><a href="/province/' . $value->id . '?url=' . $_SERVER['REQUEST_URI'] . '">' . $value->name . '</a></li>';
                                } else {
                                    echo '<li><a href="/province/' . $value->id . '?url=' . $_SERVER['REQUEST_URI'] . '">' . $value->name . '</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="right">
                <ul id="user_support">
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <li id="notifi">
                            <div class="dropdown">
                                <a class="dropdown-toggle notify_count" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative">
                                    <?= !empty($count_buyer) ? '<i class="fas fa-bell"></i><span>' . $count_buyer . '</span>' : '<i class="fas fa-bell"></i>' ?> <?= \Yii::t('frontend', 'Thông báo'); ?>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-notify" role="menu">
                                    <div class="translate" style="top: -6px;left: 36px;z-index: 9999;"></div>
                                    <li class="header-notification"><a><strong><?= \Yii::t('frontend', 'Thông báo'); ?></strong></a></li>
                                    <?php if (!empty($notification)) { ?>
                                        <?php foreach ($notification as $value) { ?>
                                            <li>
                                                <a class="read <?= $value->status == 0 ? 'active' : '' ?>" data-id="<?= $value->id ?>" href="javascript:void(0)" class="read" data-href="<?= $value->url ?>">
                                                    <span><?= $value->content ?></span><br> 
                                                    <small><i class="fas fa-clock"></i> <?= Constant::time($value->created_at) ?></small>
                                                </a>
                                                <!--     <div class="pull-right">
                                                        <a class="check-read" data-id="" title="Đánh dấu chưa đọc" href="javascript:void(0)"><i class="fa fa-eye"></i></a>
                                                    </div> -->
                                            </li>
                                        <?php } ?>
                                        <li class="footer-notification"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/notification']) ?>"><?= \Yii::t('frontend', 'Xem thêm'); ?></a></li>
                                    <?php } else { ?>
                                        <li><?= Yii::t('frontend', 'Chưa có thông báo nào !') ?></li>
                                    <?php } ?>
                                </ul>
                            </div>

                        </li>
                    <?php } ?>
                    <li><a href="<?= Yii::$app->setting->get('siteurl_forum') ?>"><?= \Yii::t('frontend', 'Diễn đàn trao đổi'); ?></a></li>
                    <li><a href="<?= Yii::$app->user->isGuest ? Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->urlManager->createAbsoluteUrl(['/invoice/history'])) : '/invoice/history' ?>"><?= \Yii::t('frontend', 'Theo dõi đơn hàng'); ?></a></li>
                    <li>
                        <?php
                        if (!Yii::$app->user->isGuest && Yii::$app->roletype->isSeller()) {
                            echo Html::a(\Yii::t('frontend', 'Bán hàng cùng Vinagex'), Yii::$app->setting->get('siteurl_seller'));
                        } else {
                            echo Html::a(\Yii::t('frontend', 'Bán hàng cùng Vinagex'), ['seller/about']);
                        }
                        ?>
                    </li>
                    <li>
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative; cursor: pointer;">
                                <?= \Yii::t('common', 'Ngôn ngữ'); ?> <span style="top: 5px" class="lang-sm" lang="<?= Yii::$app->language ?>"></span>
                            </a>
                            <ul style="left: -105px;" class="dropdown-menu" role="menu">
                                <div class="translate" style="top: -6px;right: 25px;z-index: 9999;"></div>
                                <li><?= Html::a('<span class="lang-sm lang-lbl-full" lang="vi"></span>', Url::current(['lang' => 'vi'])) ?></li>
                                <li><?= Html::a('<span class="lang-sm lang-lbl-full" lang="en"></span>', Url::current(['lang' => 'en'])) ?></li>
                                <!-- <li><a href=""><span class="lang-sm lang-lbl-full" lang="zh"></span></span></a></li> -->
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="container container-mobile">
            <div class="row">
                <div class="col-xs-3" id="bars">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div id="logo">
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('/') ?>">
                            <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png" alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-sm-5 col-xs-12" id="filter-header">
                    <div class="form-search">
                        <form id="search_form" method="get" role="search" action="/filter">
                            <div class="input-group search-wrap">
                                <div class="input-group-btn list-search">
                                    <input type="hidden" id="search_category" name="category" value="0">
                                    <button type="button" class="btn btn-default dropdown-toggle dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span><?= \Yii::t('frontend', 'Tất cả danh mục'); ?></span>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu ">
                                        <li data-category="0"><?= \Yii::t('frontend', 'Tất cả danh mục'); ?></li>
                                        <?php
                                        foreach ($category as $value) {
                                            echo '<li data-category="' . $value->id . '">- ' . Yii::t('common', trim($value['title'])) . '</li>';
                                        }
                                        ?>

                                    </ul>
                                </div>
                                <!-- /btn-group -->
                                <input type="search" id="search-key" name="keywords" id="s" autocomplete="off" value="<?= !empty($_GET['keywords']) ? $_GET['keywords'] : '' ?>" placeholder="<?= \Yii::t('frontend', 'Tìm kiếm sản phẩm'); ?>">
                                <button class="btn search-header" type="submit">
                                    <img src="/template/svg/search.svg" width="20">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-3 header-right">
                    <i class="fa fa-search icon-search"></i>
                    <div id="user_info_header">
                        <?php
                        if (Yii::$app->user->isGuest) {
                            ?>
                            <a href="<?= Yii::$app->setting->get('siteurl_id') ?>/login">
                                <img src="/template/svg/user-black.svg"> 
                                <span><?= \Yii::t('frontend', 'Đăng nhập'); ?> <br> <?= \Yii::t('frontend', 'Đăng ký'); ?></span>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= !empty(Yii::$app->user->identity->avatar) ? Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . Yii::$app->user->identity->avatar . '&size=35x35' : "/template/svg/user-black.svg" ?>"> 
                                <h5 class="name-user"><?= \Yii::t('frontend', 'Chào'); ?> <?= Constant::excerpt(Yii::$app->user->identity->fullname, 20) ?></h5><small><?= \Yii::t('frontend', 'Tài khoản'); ?></small>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/thong-tin-tai-khoan"><?= \Yii::t('frontend', 'Thông tin cá nhân'); ?></a></li>
                                <li><?= Html::a(\Yii::t('frontend', 'Quản lý báo giá'), Yii::$app->setting->get('siteurl_rfq') . '/manager/rfq'); ?></li>
                                <li><a href="/quan-ly-don-hang"><?= \Yii::t('frontend', 'Quản lý đơn hàng'); ?></a></li>
                                <li><a href="/san-pham-yeu-thich"><?= \Yii::t('frontend', 'Sản phẩm yêu thích'); ?></a></li>
                                <li><a href="/nha-vuon-ban-quan-tam"><?= \Yii::t('frontend', 'Nhà vườn đã quan tâm'); ?></a></li>
                                <li><a target="_blank" href="<?= Yii::$app->setting->get('siteurl_message') ?>"><?= \Yii::t('frontend', 'Hộp thư của bạn'); ?> <span class="badge countMsg"></span></a></li>
                                <li>
                                    <?=
                                    Html::beginForm(['/user/logout'], 'post')
                                    . Html::submitButton(
                                            \Yii::t('frontend', 'Đăng xuất'), ['class' => 'btn btn-link logout']
                                    )
                                    . Html::endForm()
                                    ?>
                                </li>
                            </ul>
                            <?php
                        }
                        ?>

                    </div>
                    <div class="header-cart">
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['/cart/checkout']) ?>">
                            <img src="/template/svg/cart-black.svg">
                            <span class="circle"><?= $cart->getTotalCount() ?></span>
                            <p class="hidden-xs hidden-sm text-cart"><?= \Yii::t('frontend', 'Giỏ hàng'); ?></p>
                        </a>

                    </div>
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        ?>
                        <div id="notification-mobile">
                            <a style="position: relative; width: 25px" href="/notification">
                                <img width="20" src="/template/svg/ring.svg" />
                                <?= !empty($count_buyer) ? '<span class="circle">' . $count_buyer . '</span>' : '' ?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="main-nav">
        <div class="container container-mobile">
            <nav class="main-nav-wrap active">
                <a href="#" class="main-nav-toggle"><span><?= \Yii::t('frontend', 'Danh mục'); ?> </span> <i class="fa fa-angle-down"></i></a>

                <ul class="list-cat" style="display: <?= (Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') ? "block" : "none" ?>">
                    <?php
                    foreach ($category as $value) {
                        ?>
                    <li><a href="/filter?category=<?= $value->id ?>"><img src="/template/svg/<?= $value->icon ?>" width="20"> <?= Yii::t('common', trim($value->title)) ?></a>
                            <?php
                        }
                        ?>
                </ul>

            </nav>
            <?= Html::a(Yii::t('frontend', 'Sản phẩm có sẵn'), ['filter/index', 'sell' => 2]) ?>
            <?= Html::a(Yii::t('frontend', 'Sản phẩm đặt trước'), ['filter/index', 'sell' => 2]) ?>
            <?= Html::a(Yii::t('frontend', 'Danh sách nhà cung cấp'), ['seller/index']) ?>
            <?= Html::a(Yii::t('frontend', 'Sản phẩm yêu cầu báo giá'), Constant::domain('rfq') . '?lang=' . Yii::$app->language) ?>
            <?= Html::a(Yii::t('frontend', 'Tạo yêu cầu báo giá'), Constant::domain('rfq') . 'manager/create?lang=' . Yii::$app->language, ['class' => 'btn btn-offer pull-right']) ?>
        </div>
    </div>
</header>
<?php ob_start(); ?>
<script type="text/javascript">
    $(".provinces-header>span").html($(".provinces-header ul li.active").text());
    $(".provinces-footer>span").html($(".provinces-footer ul li.active").text());

    $('#user_support .read').click(function () {
        var id = $(this).data('id');
        var url = $(this).data('href');
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["notification/status"]); ?>',
            type: 'POST',
            data: 'id=' + id,
            success: function (data) {
                $(location).attr('href', url);
            }
        });
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>