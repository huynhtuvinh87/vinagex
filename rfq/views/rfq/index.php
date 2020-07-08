<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use rfq\widgets\SidebarWidget;
use yii\widgets\ListView;

SidebarWidget::widget();
$this->title = 'Quản lý yêu cầu báo giá';
?>
<?= SidebarWidget::widget() ?>
<div class="container">
    <h2 class="section-title"><?= $this->title ?></h2>

    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'id' => 'list-wrapper',
        ],
        'layout' => "{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_item', ['model' => $model]);
        },
    ]);
    ?>
</div>

<?php
ob_start();
$u = uniqid();
?>
<script>
    $("body").on("click", ".offer", function () {
        $('#modalHeader span').html('Báo giá sản phẩm');
        $.get('/rfq/apply/' + $(this).attr("data-id"), function (data) {
            $('#modal-<?= $u ?>').modal('show').find('.content').html(data);
        });

    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span></span>',
    'id' => 'modal-' . $u,
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div class='content'></div>";
yii\bootstrap\Modal::end();
?>