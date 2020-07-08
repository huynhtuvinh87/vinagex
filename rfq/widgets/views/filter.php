<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\components\Constant;
?>


<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php $form = ActiveForm::begin(['action' => ['search/index'], 'id' => 'form-search', 'method' => 'get']); ?>
            <div class="has-feedback group-search">
                <div class="input-group">
                    <span class="input-group-addon">
                        <div class="dropdown show">
                            <a class="btn-sm btn-secondary dropdown-toggle title" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Danh mục <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown" aria-labelledby="dropdownMenuLink">
                                <li><a id="cate-all"  class="dropdown-item item-category" href="javascript:void(0)">Tất cả danh mục</a></li>
                                <?php foreach ($category as $value) { ?>
                                    <li><a data="<?= $value->id; ?>" class="dropdown-item item-category" href="javascript:void(0)"><?= $value->title; ?></a></li>
                                <?php } ?>

                            </div>
                        </div>
                    </span>
                    <input class="form-control text-search" type="text" name="keywords" placeholder="<?= (!empty(Yii::$app->session->getFlash('alert'))) ? Yii::$app->session->getFlash('alert') : 'Tìm kiếm ...'; ?>">
                </div> 
                <input id="sort" type="hidden" name="" value="">
                <input id="category" type="hidden" name="category" value="">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn-search']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>  
        <div class="col-md-4">
            <div class="add-question pull-right">
                <h4>
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <a href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->setting->get('siteurl_id') . $_SERVER['REQUEST_URI']) ?>" data-title="Tạo mới câu hỏi">Đăng câu hỏi</a>
                    <?php } else { ?>
                        <a href="/question/create" class="post-question" data-title="Tạo mới câu hỏi">Đăng câu hỏi</a>
                    <?php } ?>
                </h4>
            </div>
        </div>

    </div>
</div>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Thống kê chi tiết</span>',
    'id' => 'modal-question',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style=\"text-align:center\"><img src=\"my/path/to/loader.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>

<?php ob_start(); ?>
<script>

    $(".tabs a").on("click", function () {
        $('input#sort').attr('name', $(this).attr('data'));
        $('input#sort').val($(this).attr('data'));
        $('#form-search').submit();
    });

    $(".item-category").on("click", function () {
        $('.title').html($(this).html() + '<span class="caret"></span>');
        $('#category').val($(this).attr('data'));
        $('.text-search').attr('placeholder', 'Tìm kiếm câu hỏi theo: ' + $(this).html() + ' ...');
    });

    $('body').on('click', '.post-question', function (event) {
        $('#modalHeader span').html($(this).attr('data-title'));
        $.get($(this).attr('href'), function (data) {
            $('#modal-question').modal('show').find('#modalContent').html(data)
        });
        return false;
    });


</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>