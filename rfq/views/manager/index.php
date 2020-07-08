<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use rfq\widgets\SidebarWidget;
use yii\widgets\ListView;

SidebarWidget::widget();
?>
<?= SidebarWidget::widget() ?>
<div class="container">
    <h2 class="section-title"><?= $this->title ?></h2>
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => Yii::t('rfq', 'Chưa có yêu cầu nào.') . ' <a href="/manager/create">' . Yii::t('rfq', 'Tạo ngay') . '</a>',
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

<?php ob_start(); ?>
<script>
    $('body').on('click', '.offer-view', function (event) {
        $('#modalHeader').find('span').html('');
        $('#modalHeader').prepend('<span>' + $(this).attr('data-title') + '</span>');
        $.get($(this).attr('href'), function (data) {
            $('#modal-apply').modal('show').find('#modalContent').html(data)
        });
        return false;
    });

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal-apply',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>