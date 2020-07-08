<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\Html;
use common\components\Constant;
?>

<footer>
    <div class="footer-top">
        <div class="container container-mobile">
            <div class="row">
                <div class="col-sm-9 footer-menu">
                    <div class="row">
                        <div class="col-sm-4 col-b-left">
                            <section class="widget about-us-wg">
                                <h4 class="widget-title"><?= \Yii::t('common', 'Về Vinagex'); ?></h4>
                                <div class="textwidget">
                                    <ul class="menu">

                                        <?php foreach ($info as $value) { ?>
                                            <li><a href="<?= !empty($value->url) ? $value->url : '/p/' . $value->slug ?>"><?= Yii::t('data', 'page_title_' . $value->_id) ?></a></li>
                                        <?php } ?>

                                    </ul>
                                </div>
                            </section>           

                        </div>
                        <div class="col-sm-4 col-b-left">
                            <section class="widget cooperate-wg">
                                <h4 class="widget-title"><?= \Yii::t('common', 'Hợp tác & Tuyển dụng'); ?></h4>
                                <div class="textwidget">
                                    <ul class="menu">
                                        <?php foreach ($cooperate as $value) { ?>
                                            <li><a href="<?= !empty($value->url) ? $value->url : '/p/' . $value->slug ?>"><?= Yii::t('data', 'page_title_' . $value->_id) ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </section>

                        </div>
                        <div class="col-sm-4 col-b-left">
                            <section class="widget help-wg">
                                <h4 class="widget-title"><?= \Yii::t('common', 'Hướng dẫn cho người mua - người bán'); ?></h4>
                                <div class="textwidget">
                                    <ul class="menu">
                                        <?php foreach ($support as $value) { ?>
                                            <li><a target="_blank" href="<?= !empty($value->url) ? $value->url : '/p/' . $value->slug ?>"><?= Yii::t('data', 'page_title_' . $value->_id) ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 location">
                    <section class="widget location-wg">
                        <h4 class="widget-title"><?= \Yii::t('common', 'Công ty cổ phần Vinagex'); ?></h4>
                        <div class="textwidget">
                            <ul>
                                <li>
                                    <ul>
                                        <?php foreach ($address as $value) { ?>
                                            <li><a><?= Yii::t('data', trim($value->title)) ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="communication">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 news-letter">
                    <section class="widget news-letter-wg">
                        <div class="textwidget">
                            <form action="" method="post" data-toggle="validator" novalidate="novalidate" class="bv-form bv-form-bootstrap">
                                <label><?= \Yii::t('common', 'Đăng ký nhận bản tin khuyến mãi'); ?></label>
                                <div class="newsletter form-inline">
                                    <div class="form-group has-feedback">
                                        <div class="input-group">
                                            <input type="text" class="form-control newsletter-input" name="email_newsletter" placeholder="<?= \Yii::t('common', 'Nhập email của bạn...'); ?>" value="" data-bv-notempty="true" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$"  data-bv-field="email_newsletter">
                                            <input type="hidden" name="stateId" value="437">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-success newsletter__button" disabled=""><?= \Yii::t('common', 'Đăng ký'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <label for="agree2" class="control-label register-new-letter-comfirm-footer">
                                    <input type="checkbox" name="agree" id="agree2" value="1" data-bv-notempty="true" data-bv-notempty-message="Bạn cần phải đồng ý với chính sách bảo mật thông tin" data-bv-field="agree">
                                    <a target="_blank" href="#"><?= \Yii::t('common', 'Đồng ý với chính sách bảo mật.'); ?></a>
                                </label>
                            </form>
                        </div>
                    </section>
                </div>
                <div class="col-sm-4 app-store">
                    <section class="widget app-wg">
                        <h4 class="widget-title">VINAGEX APP</h4>
                        <div class="textwidget">
                            <ul>
                                <li><a href="#"><img src="/template/images/icon-appstore.png" alt=""></a></li>
                                <li><a href="#"><img src="/template/images/icon-googleplay.png" alt=""></a></li>
                            </ul>
                        </div>
                    </section>
                </div>
                <div class="col-sm-4 social">
                    <section class="widget follow-us-wg">
                        <h4 class="widget-title"><?= \Yii::t('common', 'Kết nối với chúng tôi'); ?></h4>
                        <div class="textwidget">
                            <ul class="social-items">
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li class="youtube"><a href="#"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 copyright">
                    <div class="pull-left">
                        <ul>
                            <li><a class="text-success" href="/help/join"><?= \Yii::t('common', 'Trung tâp hỗ trợ'); ?></a></li>
                            <li><?= \Yii::t('common', 'Điện thoại hỗ trợ:'); ?> 0843.286.386</li>
                            <li>Email: <a href="javascript:void(0)" class="text-success">hotro@vinagex.com</a></li>
                        </ul>
                    </div>
                    <div style="line-height: 50px" class="pull-right">
                        Vinagex 2018. All rights reserved
                    </div>
                </div>
                <div class="col-sm-2 icon">
                   <!--  <a href="#"><img src="/template/images/logo-dangky.png" alt=""></a> -->
                </div>
            </div>
        </div>
    </div>
</footer>
<?php
if ($layout == "main") {
    ?>
    <div class="menu-mobi main" id="menu-mobile">
        <a class="close-menu" href="#"><i class="remove"><img src="/template/images/close.png" alt="icon"></i></a>
        <div class="menu-mobi-wrapper">
            <div class="top-menu">
                <div class="dropdown">
                    <div class="provinces-box provinces-footer">
                        <a><i class="fas fa-map-marker-alt"></i> <?= Yii::t('common', 'Địa điểm') ?>:</a> 
                        <span></span>
                        <div class="balloon">
                            <div class="point"></div>
                            <span class="close">╳</span>
                            <span><?= \Yii::t('common', 'Chọn tỉnh thành để xem báo giá và giao hàng tại'); ?>:</span>
                            <input type="text" class="search-province" placeholder="<?= \Yii::t('common', 'Tìm kiếm tỉnh thành ...'); ?>">
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
                <div class="user">
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        if (!empty(Yii::$app->user->identity->avatar)) {
                            ?>
                            <img style="padding: 0; width: 40px;height: 40px; margin: 3px 0 0 10px;" class="avatar" src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . Yii::$app->user->identity->avatar . '&size=200x200&time=' . time() ?>">
                        <?php } else { ?>
                            <img class="img-circle" src="/template/images/no-avatar.gif" alt=""/>
                            <?php
                        }
                    }
                    ?>
                    <ul class="user-login">
                        <?php
                        if (Yii::$app->user->isGuest) {
                            ?>
                            <li class="signup"><a href="<?= Yii::$app->setting->get('siteurl_id') ?>/register"><?= \Yii::t('common', 'Đăng ký'); ?></a></li>
                            <li class="login"><a href="<?= Yii::$app->setting->get('siteurl_id') ?>/login"><?= \Yii::t('common', 'Đăng nhập'); ?></a></li>
                            <?php
                        } else {
                            ?>
                            <li class="signup"><a style="border: 0" href="/user/profile"><?= \Yii::t('common', 'Chào'); ?> <span style="color: #fff"><?= Yii::$app->user->identity->fullname ?></span></a></li><br>
                            <li><a href="/user/profile"><small><?= \Yii::t('common', 'Tài khoản'); ?></small></a></li>
                            <li><a><?=
                                    Html::beginForm(['/user/logout'], 'post')
                                    . Html::submitButton(
                                            \Yii::t('common', 'Đăng xuất'), ['class' => 'btn btn-link logout', 'style' => 'margin:0;padding: 0;font-size: 85%;color: #444444']
                                    )
                                    . Html::endForm()
                                    ?></a></li>
                            <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
            <div class="list-menu">

                <?php
                if (!Yii::$app->user->isGuest) {
                    ?>
                    <nav class="side-nav">
                        <ul class="nav-menu nav-menu1">
                            <?php
                            if (Yii::$app->user->identity->role == Constant::ROLE_MEMBER) {
                                ?>
                                <li><a href="/order/history"><?= \Yii::t('common', 'Quản lý đơn hàng'); ?></a></li>
                                <li><a href="/san-pham-da-luu"><?= \Yii::t('common', 'Sản phẩm đã lưu'); ?></a></li>
                                <li><a href="/nha-vuon-ban-quan-tam"><?= \Yii::t('common', 'Nhà vườn quan tâm'); ?></a></li>
                                <li><a target="_blank" href="<?= Yii::$app->setting->get('siteurl_message') ?>"><?= \Yii::t('common', 'Hộp thư của bạn'); ?> <span class="badge countMsg"></span></a></li>
                                <?php
                            } else {
                                ?>
                                <li><a href="<?= Yii::$app->user->isGuest ? Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->urlManager->createAbsoluteUrl(['/invoice/history'])) : '/invoice/history' ?>"><?= \Yii::t('common', 'Quản lý đơn hàng'); ?></a></li>
                                <li><a href="/nha-vuon-ban-quan-tam"><?= \Yii::t('common', 'Nhà vườn quan tâm'); ?></a></li>
                                <li><a target="_blank" href="<?= Yii::$app->setting->get('siteurl_message') ?>"><?= \Yii::t('common', 'Hộp thư của bạn'); ?> <span class="badge countMsg"></span></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </nav>
                    <?php
                }
                ?>
                <nav class="side-nav">
                    <ul class="nav-menu nav-menu1">
                        <li><a href="<?= Yii::$app->user->isGuest ? Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_forum')) : Yii::$app->setting->get('siteurl_forum') ?>"><?= \Yii::t('common', 'Diễn đàn trao đổi'); ?></a></li>
                        <li><a href="/seller/about"><?= \Yii::t('common', 'Bán hàng cùng Vinagex'); ?></a></li>
                        <li><?= Html::a(Yii::t('common', 'Sản phẩm yêu cầu báo giá'), Constant::domain('rfq') . '?lang=' . Yii::$app->language) ?></li>
                    </ul>
                </nav> 
                <nav class="side-nav">
                    <ul class="nav-menu nav-menu1">
                        <li><a href="/filter?sell=1"><?= \Yii::t('common', 'Sản phẩm có sẵn'); ?></a></li>
                        <li><a href="/filter?sell=2"><?= \Yii::t('common', 'Sản phẩm đặt trước'); ?></a></li>
                        <li><a href="/seller"><?= \Yii::t('common', 'Danh sách nhà cung cấp'); ?></a></li>
                    </ul>
                </nav>
                <nav class="side-nav side-nav-branding">
                    <ul class="branding_menu">
                        <?php
                        foreach ($category as $value) {
                            ?>
                            <li><a href="/filter?category=<?= $value->id ?>"><img src="/template/svg/<?= $value->icon ?>" width="20"> <?= yii::t('common', trim($value->title)) ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <div class="hotline">
                <span class="hotline_text">HOTLINE</span>
                <span class="hotline_number">0843.286.386</span>
            </div>
        </div>
    </div>
    <?php
}
if ($layout == "seller_about") {
    ?>
    <div class="menu-mobi intro">
        <a class="close-menu" href="#"><i class="remove"><img src="images/close.png" alt="icon"></i></a>
        <nav class="side-nav side-nav-branding">
            <ul class="branding_menu">
                <li class="branding-restaurant"><a href="#">Giới thiệu</a></li>
                <li class="branding-beauty"><a href="#">Tìm hiểu chính sách</a></li>
                <li class="branding-entertainment"><a href="/ho-chi-minh/giai-tri-va-dao-tao/">Chào nhà bán mới</a></li>
            </ul>
        </nav>
    </div>
    <?php
}
?>