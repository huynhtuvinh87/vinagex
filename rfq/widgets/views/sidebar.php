<?php

use yii\bootstrap\Html;
?>	
<div class="sidebar">
    <div class="container">
        <ul class="nav">

            <li class="nav-item">
                <?= Html::a(Yii::t('rfq', 'Yêu cầu báo giá của bạn') . ' <span class="badge badge-primary badge-pill">' . $count_rfq . '</span>', ['manager/rfq'], ['class' => 'nav-link']) ?>

            </li>
            <li class="nav-item">
                <?= Html::a(Yii::t('rfq', 'Báo giá của bạn') . ' <span class="badge badge-primary badge-pill">' . $count_apply . '</span>', ['manager/apply'], ['class' => 'nav-link']) ?>
            </li>
        </ul>

    </div>
</div>