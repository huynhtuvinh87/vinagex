<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
?>
<ul class="list-group">
    <li class="list-group-item general"><a href="/site/index">Tổng quan</a></li>
</ul>
<ul class="list-group">
    <li class="list-group-item order"><span class="badge"><?= $count_order ?></span><a href="/order">Quản lý đơn hàng</a></li>
</ul>
<ul class="list-group">
    <li class="list-group-item comment"><span class="badge"><?= $comment ?></span><a href="/comment">Bình luận sản phẩm</a></li>
</ul>
 
</ul>
<ul class="list-group">
	<div class="title-gr-menu product">Quản lý sản phẩn</div>
    <li class="list-group-item"><span class="badge"><?= $cpp ?></span><a href="/product/pending">Sản phẩm chờ duyệt </a></li>
    <li class="list-group-item"><span class="badge"><?= $cpa ?></span><a href="/product/verified">Sản phẩm đã duyệt</a></li>
    <li class="list-group-item"><span class="badge"><?= $cpb ?></span><a href="/product/block">Sản phẩm đã hết hàng</a></li>
    <li class="list-group-item"><span class="badge"><?= $cpc ?></span><a href="/product/canceled">Sản phẩm bị từ chối </a></li>
</ul>
<ul class="list-group">
	<div class="title-gr-menu">Tài khoản bán hàng</div>
	<li class="list-group-item info"><a href="/seller/index">Thông tin chung</a></li>
    <li class="list-group-item payment"><a href="/payment">Thông tin thanh toán</a></li>
    <li class="list-group-item report"><a href="/report">Báo cáo vi phạm</a></li>
    <!--<li class="list-group-item">Thống kê</li>-->
    <li class="list-group-item help">
        <a target="_blank" href="<?= Yii::$app->setting->get('siteurl') . '/help/join'; ?>"> Hướng dẫn & trợ giúp</a>
    </li>
    <li class="list-group-item password"><a href="/seller/password">Thay đổi mật khẩu</a></li>
    <li class="list-group-item logout">
        <?=
        Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
                'Thoát', ['class' => 'btn btn-link logout', 'style' => "padding: 0; color: #333"]
        )
        . Html::endForm()
        ?>
    </li>
</ul>