<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="pull-right">
                <?php
                $form = ActiveForm::begin([
                            'method' => 'GET',
                            'options' => [
                                'class' => 'form-inline'
                            ]
                ]);
                ?>
                <?= $form->field($search, 'keywords')->textInput()->label(FALSE) ?>
                <button type="submit" class="btn btn-default" style="margin-top: -5px;">Tìm kiếm</button>
                <?php ActiveForm::end(); ?>
            </div>

            <?php
            Pjax::begin([
                'id' => 'pjax_gridview_product',
            ])
            ?>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'productAction',
                        'action' => ['doaction'],
                        'options' => [
                            'class' => 'form-inline'
                        ]
            ]);
            ?>
            <div class="pull-left">

                <?= Html::a('Xuất excel', ['excel'], ['class' => 'btn btn-primary']) ?>
            </div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                    [
                        'attribute' => 'title',
                        'format' => 'raw',
                        'value' => function($data) {
                            if ($data->status == Constant::STATUS_NOACTIVE) {
                                $url = Yii::$app->setting->get('siteurl') . '/product/preview/' . $data->id;
                            } else {
                                $url = Yii::$app->setting->get('siteurl') . '/' . $data->slug . '-' . $data->id;
                            }
                            $html = '<div class="row"><div class="col-sm-5 col-md-4 col-lg-2"><a href=' . $url . ' target="_blank"><img class="img-responsive" width="60" src="' . Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $data->images[0] . '&size=60&60"></a></div>';
                            $html .= '<div class="col-sm-7 col-md-8 col-lg-10">';
                            $html .= "<a href='" . $url . "' target='_blank'><span>" . $data->title . "</span></a>";
                            $html .= "<p>";
                            if ($data->status == Constant::STATUS_NOACTIVE) {
                                $html .= '<a href="/product/status/' . $data->id . '?s=' . Constant::STATUS_ACTIVE . '"><span>Duyệt</span></a> | ';
                                $html .= '<a class="cancel" href="/product/cancel/' . $data->id . '">Từ chối</a>';
                            } else {
                                if ($data->status == Constant::STATUS_CANCEL) {
                                    $html .= '<a class="delete" data-method="POST" href="/product/delete/' . $data->id . '">Xóa</a>';
                                } else {
                                    $html .= '<a class="cancel" href="/product/cancel/' . $data->id . '?s=' . Constant::STATUS_BLOCK . '">Khoá</a>';
                                }
                            }
                            $html .= "</p>";
                            $html .= "</div>";
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'Danh mục',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->category['title'];
                        },
                    ],
                    [
                        'attribute' => 'Nhà vườn',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->owner['garden_name'];
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw',
                        'value' => function($data) {
                            return date('d/m/Y', $data->created_at) . '<br><small>' . date('d/m/Y h:i:s', $data->updated_at) . '</small>';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                $view = '';
                                if ($model->status == Constant::STATUS_NOACTIVE) {
                                    $view .= Html::a('Chi tiết', Yii::$app->setting->get('siteurl') . '/product/preview/' . $model->id, [
                                                'title' => 'Xem',
                                                'target' => '_blank'
                                    ]);

                                    $view .= Html::a(' | Xoá', $url, [
                                                'title' => 'delete',
                                                'data-confirm' => Yii::t('yii', 'Bạn có muốn xoá sản phẩm này không?'),
                                                'data-method' => 'post',
                                    ]);
                                } else {
                                    $view .= Html::a('Chi tiết', Yii::$app->setting->get('siteurl') . '/product/view/' . $model->id, [
                                                'title' => 'Xem',
                                                'target' => '_blank'
                                    ]);
                                    $view .= Html::a('<br>Cập nhật sản phẩm', ['/image/index', 'id' => $model->id]);
                                }
                                return $view;
                            },
                        ],
                        'headerOptions' => ['width' => 100]
                    ],
                ],
            ]);
            ?>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end() ?> 
        </div>
    </div>
</div>
<?= $this->registerJs("
$(document).ready(function() {
    $('form#productAction button[type=submit]').click(function() {
        return confirm('Rollback deletion of candidate table?');
    });

    $('.delete').click(function() {
        return confirm('Bạn có muốn xóa?');
    });
});
") ?>

<?php
$u = uniqid();
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Thống kê chi tiết</span>',
    'id' => 'modal-' . $u,
    'size' => 'modal-lg',
    'footer' => '<button id="status" type="button" class="btn btn-success">Duyệt</button>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div class='modalContent'>
</div>

<?php
yii\bootstrap\Modal::end();
?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span></span>',
    'id' => 'modal-cancel',
    'footer' => '<button id="cancel" class="btn btn-success pull-right">Đồng ý</button>',
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
    $('body').on('click', '.view_img', function (event) {
        var status = parseInt($(this).attr("data-status"));
        $('#modalHeader span').html($(this).attr('data-title'));
        $.get($(this).attr('href'), function (data) {
            if (data) {
                $('#modal-<?= $u ?>').modal('show').find('.modal-footer').show();
                if (status == 3) {
                    $('#modal-<?= $u ?>').modal('show').find('.modal-footer').html('<button id="status" data-status="2" type="button" class="btn btn-success">Duyệt</button>');
                } else {
                    $('#modal-<?= $u ?>').modal('show').find('.modal-footer').html('<button id="status" data-status="3" type="button" class="btn btn-success">Đã duyệt</button>');
                }
                $('#modal-<?= $u ?>').modal('show').find('.modalContent').html(data);
            } else {
                $('#modal-<?= $u ?>').modal('show').find('.modalContent').html("Sản phẩm này chưa được cập nhật!");
                $('#modal-<?= $u ?>').modal('show').find('.modal-footer').hide();
                $('#modal-<?= $u ?>').modal('show').find('.modal-footer').html("");
            }
        });
        return false;
    });

    $("body").on("click", ".cancel", function (event) {
        event.preventDefault();
        $('#modal-product').modal('hide');
        $.get($(this).attr('href'), function (data) {
            $('#modal-cancel').find('#modalHeader span').html('<b>Lý do không duyệt sản phẩm</b>')
            $('#modal-cancel').modal('show').find('#modalContent').html(data);
        });
    });

    $("body").on("click", "#cancel", function (event) {
        event.preventDefault();
        $('#cancel-form').submit();
    });
    $(document).on('click', '#status', function () {
        var id = $("#product_id").val();
        $.ajax({
            type: "POST",
            url: "/product/statusimage/" + id,
            data: {status: $(this).attr('data-status')},
            success: function (data) {
                $.pjax({container: '#pjax_gridview_product'});
                $('#modal-<?= $u ?>').modal('hide');
            },
        });
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
