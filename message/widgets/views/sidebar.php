<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
?>
<ul class="list-group">
    <li class="list-group-item"><a href="/seller/index">Tổng quan nhà vườn</a></li>
    <li class="list-group-item">Đăng sản phẩm
        <ul style="margin-left: 20px">
            <?php
            foreach (common\components\Constant::category() as $key => $value) {
                ?>
                <li style="padding: 5px 0"><a href="/product/create?id=<?= $key ?>"><?= $value ?></a></li>
                <?php
            }
            ?>
        </ul>
    </li>
    <li class="list-group-item"><span class="badge"><?= $cs ?></span><a href="/product/index">Sản phẩm đang bán</a></li>
    <li class="list-group-item"><span class="badge"><?= $cto ?></span><a href="/product/index">Sản phẩm hết thời gian bán</a></li>
    <li class="list-group-item"><span class="badge"><?= $cpp ?></span><a href="/product/pending">Sản phẩm chờ duyệt </a></li>
    <li class="list-group-item"><span class="badge"><?= $cpa ?></span><a href="/product/verified">Sản phẩm đã duyệt</a></li>
    <li class="list-group-item"><span class="badge"><?= $order_pending ?></span><a href="/order/pending">Đơn hàng đang xử lý</a></li>
    <li class="list-group-item"><span class="badge"><?= $order_sending ?></span><a href="/order/sending">Đơn hàng đang giao</a></li>
    <li class="list-group-item"><span class="badge"><?= $order_complete ?></span><a href="/order/complete">Đơn hàng đã hoàn thành</a></li>
    <!--<li class="list-group-item">Thống kê</li>-->
    <li class="list-group-item"><a href="/seller/password">Thay đổi mật khẩu</a></li>
    <li class="list-group-item">
        <?=
        Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
                'Thoát', ['class' => 'btn btn-link logout', 'style' => "padding: 0; color: #333"]
        )
        . Html::endForm()
        ?>
    </li>
</ul>