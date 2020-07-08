<?php
use rfq\widgets\SidebarWidget;
$this->title = "Tạo yêu cầu bào giá";
?>
<?= SidebarWidget::widget() ?>
<div class="container">
    <h2><?= $this->title ?></h2>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
