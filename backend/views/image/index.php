<?php

use yii\grid\GridView;
use yii\bootstrap\Html;
use common\components\Constant;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$u = uniqid();
$form = ActiveForm::begin([
            'id' => 'form-' . $u,
            'action' => ['all', 'id' => (string) $product['_id']],
            'method' => 'POST',
            'options' => [
                'class' => 'form-inline'
            ]
        ]);
?>
<div class="pull-left">
    <select name="action" class="form-control">
        <option value="delete">Xoá</option>
        <option value="active">Duyệt</option>
        <option value="cancel">Từ chối</option>
    </select>
    <button type="submit" class="btn btn-primary" style="margin-top: 5px">Áp dụng</button>
</div>
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
                    $view .= Html::a('Chi tiết', ['view', 'id' => (string) $model['_id']], [
                                'title' => 'Chi tiết',
                                'class' => 'image_view',
                                'data-title' => 'Thông tin mới cho sản phẩm: ' . $model['product']['title'].'-'.date('h:i d/m/Y')
                    ]);

                    $view .= Html::a(' | Xoá', ['delete', 'id' => (string) $model['_id']], [
                                'title' => 'delete',
                                'data-confirm' => 'Bạn có muốn xoá mục này không?',
                                'data-method' => 'post',
                    ]);
                    if ($model['status'] != Constant::STATUS_ACTIVE) {
                        $view .= Html::a(' | Duyệt', ['active', 'id' => (string) $model['_id']], [
                                    'title' => 'Cập nhật',
                                    'class' => 'image_status'
                        ]);
                    }
                    if ($model['status'] != Constant::STATUS_CANCEL) {
                        $view .= Html::a(' | Từ chối', ['cancel', 'id' => (string) $model['_id']], [
                                    'title' => 'Cập nhật',
                                    'class' => 'image_status'
                        ]);
                    }
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
    'header' => '<span></span>',
    'id' => 'modal-image',
    'size' => 'modal-lg',
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
    $("body").on("click", ".image_view", function (event) {
        event.preventDefault();
        var title = $(this).attr('data-title');
        $.get($(this).attr('href'), function (data) {
            $('#modal-image').modal('show').find('#modalContent').html(data);
            $('#modal-image #modalHeader span').html(title);
        });
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
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

