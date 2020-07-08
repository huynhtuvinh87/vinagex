<?php

use yii\grid\GridView;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use common\components\Constant;

$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$u = uniqid();
$form = ActiveForm::begin([
            'id' => 'form-' . $u,
            'action' => ['deleteall', 'id' => (string) $product['_id']],
            'method' => 'POST',
            'options' => [
                'class' => 'form-inline'
            ]
        ]);
?>
<button type="submit" class="btn btn-danger" style="margin-bottom: 20px">Xoá tất cả</button>
<a href="/image/upload/<?= (string) $product['_id'] ?>" class="btn btn-primary image_add" data-title="<?= 'Cập nhật mới cho sản phẩm: ' . $product['title'] ?>" style="margin-bottom: 20px">Thêm mới</a>


<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{summary}\n{pager}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
        [
            'class' => 'yii\grid\CheckboxColumn',
            'checkboxOptions' => function($model) {
                return ['value' => (string) $model['_id']];
            },
            'multiple' => true,
            'headerOptions' => ['width' => 10]
        ],
        [
            'attribute' => 'Mô tả',
            'format' => 'raw',
            'value' => function($data) {
                return Constant::excerpt($data['content'], 100);
            },
        ],
        [
            'attribute' => 'Trạng thái',
            'format' => 'raw',
            'value' => function($data) {
                switch ($data['status']) {
                    case Constant::STATUS_ACTIVE:
                        return "Đã duyệt";
                        break;
                    case Constant::STATUS_CANCEL:
                        return "Từ chối";
                        break;
                    default :
                        return "Chưa duyệt";
                }
            }
        ],
        [
            'attribute' => 'Ngày đăng',
            'format' => 'raw',
            'value' => function($data) {
                return date('d/m/Y', $data['created_at']) . '<br><small>' . date('d/m/Y h:i:s', $data['updated_at']) . '</small>';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    $view = '';
                    $view .= Html::a('Chi tiết', Yii::$app->setting->get('siteurl') . '/product/info/' . $model['product']['id'], [
                                'title' => 'Xem',
                                'target' => '_blank'
                    ]);

                    $view .= Html::a(' | Xoá', ['delete', 'id' => (string) $model['_id']], [
                                'title' => 'delete',
                                'data-confirm' => 'Bạn có muốn xoá mục này không?',
                                'data-method' => 'post',
                    ]);

                    $view .= Html::a(' | Cập nhật', ['update', 'id' => (string) $model['_id']], [
                                'title' => 'Cập nhật',
                                'class' => 'image_add',
                                'data-title' => 'Cập nhật mới cho sản phẩm: ' . $model['product']['title']
                    ]);

                    return $view;
                },
            ],
            'headerOptions' => ['width' => 200]
        ],
    ],
]);
?>

<?php ActiveForm::end(); ?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Thêm mới album ảnh</span>',
    'id' => 'modal-image',
    'size' => 'modal-lg',
    'footer' => '<button id="submit-product-image" type="button" class="btn btn-success">Đồng ý</button>',
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
    $("body").on("click", ".image_add", function (event) {
        event.preventDefault();
        var title = $(this).attr("data-title");
        $.get($(this).attr('href'), function (data) {
            $('#modal-image').modal('show').find('#modalContent').html(data);
            $('#modal-image #modalHeader span').html(title);
        });
    });
    $('body').on('click', '.close_modal_upload', function () {
        $('.modal-upload').modal('hide');
    });
    $("body").on("click", "#submit-product-image", function (event) {
        $.ajax({
            type: "POST",
            url: $("#form-image").attr("action"),
            data: $("form#form-image").serialize(),
            success: function (data) {
//                $("#form-date").find('.errors').html(data);
            },
        });
    })
    $('form#form-<?= $u ?> button[type=submit]').click(function () {
        return confirm('Bạn có muốn thực hiện yêu cầu này không?');
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

