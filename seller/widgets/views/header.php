<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;
?>
<div class="container-fluid" style="border-bottom: 1px solid #ddd; padding: 5px 15px">
    <div class="row">
        <div class="col-sm-4 col-xs-4">
            <a href="<?= Yii::$app->setting->get('siteurl') ?>"><img id='logo' src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png"></a>
        </div>
        <div class="col-sm-8 col-xs-8">
            <?php
            $menuItems = [
                ['label' => 'Trang chủ', 'url' => ['site/index']],
            ];
            $subItems = [
                ['label' => 'Thông tin tài khoản', 'url' => ['seller/index']],
                ['label' => 'Thay đổi mật khẩu', 'url' => ['seller/password']],
            ];
            $subItems[] = '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                            'Thoát', ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>';
            $menuItems[] = ['label' => '<i class="fab fa-facebook-messenger fa-18"></i><span id="msg" class="badge"></span>', 'url' => Yii::$app->setting->get('siteurl_message'), 'linkOptions' => ['target' => '_blank', 'title' => 'Tin nhắn']];
            $menuItems[] = ['label' => '<i class="fas fa-bell fa-18"></i>' . (!empty($count_notification) ? '<span>' . $count_notification . '</span>' : '') . '', 'url' => ['/notification'], 'linkOptions' => ['id' => 'notification', 'title' => 'Thông báo']];
            $menuItems[] = ['label' => '<i class="fas fa-user fa-18"></i> ', 'url' => ['/seller/index'],
                'items' => $subItems
            ];

            echo Nav::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'navbar-menu-seller'],
                'items' => $menuItems,
            ]);
            ?>
        </div>
    </div>
</div>