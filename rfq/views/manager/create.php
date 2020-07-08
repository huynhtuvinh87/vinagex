<?php

use rfq\widgets\SidebarWidget;

$this->title = Yii::t('rfq', 'Tạo yêu cầu báo giá');
?>
    <?= SidebarWidget::widget() ?>
<div class="container">
    <h2><?= $this->title ?></h2>
<?= $this->render('_form', ['model' => $model]) ?>
</div>
