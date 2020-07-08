<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use rfq\widgets\SidebarWidget;
use yii\widgets\ListView;
use common\widgets\Alert;

SidebarWidget::widget();
$this->title = Yii::t('rfq', 'Danh sách yêu cầu sản phẩm');
?>
<?= SidebarWidget::widget() ?>
<div class="container">
    <?= Alert::widget() ?>
    <h2 class="section-title"><?= $this->title ?></h2>
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => Yii::t('rfq', 'Chưa có yêu cầu nào!'),
        'options' => [
            'tag' => 'div',
            'id' => 'list-wrapper',
        ],
        'layout' => "{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('/rfq/_item', ['model' => $model]);
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
        $('#modalHeader h4').html('<?= Yii::t('rfq', 'Báo giá') ?>');
        $.get('/rfq/apply/' + $(this).attr("data-id"), function (data) {
            $('#modal-<?= $u ?>').modal('show').find('.content').html(data);
        });
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<h4></h4>',
    'id' => 'modal-' . $u,
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div class='content'></div>";
yii\bootstrap\Modal::end();
?>