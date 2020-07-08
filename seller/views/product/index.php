<?php

use yii\widgets\ListView;
use common\widgets\Alert;
use common\components\Constant;

$this->params['breadcrumbs'][] = $this->title;
?>

<?=

ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'tag' => 'div',
        'id' => 'list-wrapper',
    ],
    'itemOptions' => ['class' => 'col-xs-6 col-sm-2'],
    'emptyText' => 'Chưa có sản phẩm nào.',
    'layout' => "<div class='row gird'>{items}</div><div class='row'><div class='col-sm-12 pagination-page'>{pager}</div></div>",
    'itemView' => '_item',
]);
?>


<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Chú ý!</span>',
    'id' => 'modal-cancel',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div id='modalContent'>
</div>
<?php
yii\bootstrap\Modal::end();
?>

<?php ob_start(); ?>
<script>
        $("body").on("click", ".cancel", function (event) {
            event.preventDefault();
            $('#modal-cancel').find('#modalHeader span').html('<b>Lý do từ chối sản phẩm</b>')
            $.get($(this).attr('href'), function (data) {
                $('#modal-cancel').modal('show').find('#modalContent').html(data);
            });
        });

        $('.update-qtt-stock').click(function() {
            return confirm('Vui lòng cập nhật lại kho hàng.');
        });

        $('.block').click(function() {
            return confirm('Sản phẩm đã hết hàng?');
        });

        $('.remove').click(function() {
            return confirm('Bạn có chắc muốn xóa sản phẩm?');
        });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

