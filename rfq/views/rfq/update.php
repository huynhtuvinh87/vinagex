<?php
use rfq\widgets\SidebarWidget;
$this->title = $model['title'];
?>
<?= SidebarWidget::widget() ?>
<div class="container">
    <h2><?= $this->title ?></h2>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
