<div class="menu-seller">
    <?php if (!empty($_GET['type'])) { ?>
        <div style="margin: 0 10px 10px 10px; border-bottom: 2px solid #FFF">
            <h3><?= Yii::t('data', 'seller_garden_name_' . $model->id) ?></h3>
            <?= $model->active['insurance_money'] == 1 ? "<a>" . \Yii::t('common', 'Đã đóng bảo hiểm: ') . number_format($model->insurance_money) . " ₫</a>" : "" ?>
        </div>
    <?php } ?>

    <ul>
        <li class="<?= empty($_GET['type']) ? "list-group-item-success" : "" ?>"><a href="<?= $model->url ?>"><span><?= \Yii::t('common', 'Thông tin cơ bản') ?></span></a></li>
        <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "product")) ? "list-group-item-success" : "" ?>"><a href="<?= $model->url ?>?type=product"><span><?= Yii::t('common', 'Sản phẩm') ?></span></a></li>
        <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "review")) ? "list-group-item-success" : "" ?>"><a href="<?= $model->url ?>?type=review"><span><?= Yii::t('common', 'Đánh giá') ?></span></a></li>
        <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "history")) ? "list-group-item-success" : "" ?>"><a href="<?= $model->url ?>?type=history"><span><?= Yii::t('common', 'Lịch sử giao dịch') ?></span></a></li>
        <li class="<?= (!empty($_GET['type']) && ($_GET['type'] == "static")) ? "list-group-item-success" : "" ?>"><a href="<?= $model->url ?>?type=static"><span><?= \Yii::t('common', 'Thống kê') ?></span></a></li>
       <!--  <li class="<?php //(!empty($_GET['type']) && ($_GET['type']=="certification")) ? "list-group-item-success" : ""    ?>"><a href="/nha-vuon/<?php //$model->username    ?>?type=certification"><span>Chứng nhận</span></a></li> -->
    </ul>
</div>