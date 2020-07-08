<?php

use yii\bootstrap\Html;
?>
<div id="sidebar" class="grid-sub">
    <div class="sidebar__inner">
        <div class="header-mobi">
            <a href="#" class="btn back"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?= Yii::t('common', 'Quay lại') ?></a>
            <?= Yii::t('common', 'Danh mục') ?>
        </div>
        <ul class="nav nav-list">
            <li class="nav-header nav-header-first"><?= \Yii::t('common', 'Tổng quan') ?></li>
            <li class="<?= empty($_GET['type']) ? "active" : "" ?>"><a href="<?= $model->url ?>"><span><?= \Yii::t('common', 'Thông tin cơ bản') ?></span></a></li>
            <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "certification")) ? "active" : "" ?>"><a href="<?= $model->url ?>?type=certification"><span><?= \Yii::t('common', 'Giấy phép, chứng nhận') ?></span></a></li>
            <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "review")) ? "active" : "" ?>"><a href="<?= $model->url ?>?type=review"><span><?= \Yii::t('common', 'Đánh giá và nhận xét') ?></span></a></li>
            <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "product")) ? "active" : "" ?>"><a href="<?= $model->url ?>?type=product"><span><?= \Yii::t('common', 'Sản phẩm') ?></span></a></li>
            <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "history")) ? "active" : "" ?>"><a href="<?= $model->url ?>?type=history"><span><?= \Yii::t('common', 'Lịch sử giao ') ?></span></a></li>
            <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "static")) ? "active" : "" ?>"><a href="<?= $model->url ?>?type=static"><span><?= \Yii::t('common', 'Thống kê') ?></span></a></li>
        </ul>
    </div>
</div>