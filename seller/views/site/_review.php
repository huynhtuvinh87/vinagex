<?php

use common\components\Constant;
?>
<div class="item">
    <div class="middle">
        <div class="review-avatar">
            <a target="_blank" href="/user/view/<?= $model->actor['id'] ?>">
             <?php if (!empty($model->user['avatar'])) { ?>
                        <img class="avatar" src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $model->user['avatar'] . '&size=250x250&time='. time()?>">
                    <?php }else{ ?>
                        <i class='fas fa-user'></i>
                    <?php } ?>
            </a>
        </div>
        <div class="top">
            <div class="star">
                <div class="empty-stars"></div>
                <div class="full-stars" style="width:<?= $model->star * 20 ?>%"> </div>
            </div>
            <span class="pull-right"><?= Constant::time($model->created_at) ?></span>
        </div>
       <div class="review-content">
            Bởi <b><a target="_blank" href="/user/view/<?= $model->actor['id'] ?>"><?= $model->actor['fullname']?$model->actor['fullname']:$model->actor['username'] ?></a></b>
            <?php
            if ($model->getVerified() > 0) {
                ?>
                <span>                                  
                    <img class="verifyimg" width="15" height="16" src="/template/images/verified.png" alt=""/>                                  
                    <span class="verify">Chứng nhận đã mua sản phẩm</span>
                </span>
                <?php
            }
            ?>
            <p class="p-title">Sản phẩm: <a href="/<?= $model->product['slug'].'-'.$model->product['id'] ?>"><?= $model->product['title'] ?></a></p>
       </div>
    </div>
    <div class="content"><?= $model->content ?></div>
</div>
