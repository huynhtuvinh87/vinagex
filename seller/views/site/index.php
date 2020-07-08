<?php
/* @var $this yii\web\View */
use common\components\Constant;
use yii\helpers\Html;

$this->title = 'Tổng quan';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <!-- item -->
    <div style="margin-bottom: 20px;" class="col-xs-12">
        <h4>Thông báo gần đây</h4>
        <hr style="margin: 0">
        <?= $this->render('notification',['notification' => $notification]) ?>
    </div>
    <!-- item -->
    <div style="margin-bottom: 20px;" class="col-xs-12">
        <h4>Thống kê giao dịch</h4>
        <hr style="margin: 0">
        <?= $this->render('static',['static' => $static,'order_finish' => $order_finish]) ?>
    </div>
    <!-- item -->
    <div style="margin-bottom: 20px;" class="col-xs-12">
        <h4>Lịch sử giao dịch</h4>
        <hr style="margin: 0">
        <?= $this->render('history',['dataProviderHistory'=>$dataProviderHistory]); ?>
    </div>
     <!-- item -->
<!--     <div style="margin-bottom: 20px;" class="col-xs-12">
        <h4>Đánh gía và nhận xét</h4>
        <hr style="margin: 0">
        <?php //$this->render('review',['dataProviderReview'=>$dataProviderReview,'model'=>$model]); ?>
        </div>
    </div> -->

<?php ob_start(); ?>
<script>

        $('.read').click(function(){
            var id = $(this).data('id');
            var url = $(this).data('href');
            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(["notification/status"]); ?>',
                type: 'POST',
                data: 'id='+id,
                success: function (data) {
                    $(location).attr('href', url);
                }
            });
        });

        $('.check-read').click(function(){
            var id = $(this).data('id');
            var count = parseInt($('#notification span').text());

            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(["notification/checkread"]); ?>',
                type: 'POST',
                data: 'id='+id,
                success: function (data) {
                    if(data == 0){
                        $("#item-"+id).removeClass("active");
                        $("#item-"+id).addClass("noactive");
                        $('#notification span').html(count+1);
                        if(isNaN(count)){
                            $("#notification").append("<span>1<span>");
                        }
                        $("#item-"+id+" .check-read").attr('title','Đánh dấu đã đọc');
                    }else{
                        $("#item-"+id).removeClass("noactive");
                        $("#item-"+id).addClass("active");
                        $('#notification span').html(count-1);
                        if(count-1 == 0){
                            $('#notification span').remove();
                        }
                        $("#item-"+id+" .check-read").attr('title','Đánh dấu chưa đọc');
                    }
                    return false;
                }
            });
        });

        $('.static_item').click(function () {
            var title = $(this).attr('data-title');
            $.get($(this).attr('href'), function (data) {
                $('#modal-static').modal('show').find('#modalContentStatic').html(data);
                $('#modalHeaderStatic span').html(title);
            });
            return false;
        });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeaderStatic'],
    'header' => '<span></span>',
    'id' => 'modal-static',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div id='modalContentStatic'>

</div>
<?php
yii\bootstrap\Modal::end();
?>