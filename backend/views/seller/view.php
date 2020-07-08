<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @vavar_dur $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = ['label' => 'Danh sách', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'fullname',
                    [
                        'attribute' => 'garden_name',
                        'format' => 'raw',
                        'value' => $model->garden_name . '<span class="pull-right">' . $form->field($model, "active[garden_name]")->checkbox(['label' => 'Xác thực']) . '</span>'
                    ],
                    'email',
                    [
                        'attribute' => 'address',
                        'format' => 'raw',
                        'value' => $model->address . ', ' . $model->ward['name'] . ', ' . $model->district['name'] . ', ' . $model->province['name'] . '<span class="pull-right">' . $form->field($model, "active[address]")->checkbox(['label' => 'Xác thực']) . '</span>'
                    ],
                    [
                        'attribute' => 'phone',
                        'format' => 'raw',
                        'value' => $model->phone . '<span class="pull-right">' . $form->field($model, "active[phone]")->checkbox(['label' => 'Xác thực']) . '</span>'
                    ],
                    [
                        'attribute' => 'certificate',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '<div class="row">';
                            $html .= '<div class="col-sm-10"><div class="row">';
                            if (!empty($model->certificate)) {
                                foreach ($model->certificate as $k => $value) {
                                    if (!empty($value['image'])) {
                                        $html .= '<div class="col-sm-3"><h4>' . $value['name'] . '</h4><a href="' . Yii::$app->setting->get('siteurl_cdn') . '/' . $value['image'] . '" data-lightbox="' . $value['id'] . '"><img data-name="' . $value['name'] . '" data-src="' . Yii::$app->setting->get('siteurl_cdn') . '/' . $value['image'] . '" src="' . Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $value['image'] . '&size=200x280"></a>
                                    <div class="row"><div class="col-sm-12">
                                    <span>' . Html::checkbox('active_certificate[]', $value['active'] == 1 ? TRUE : FALSE, ['label' => 'Xác thực', 'class' => 'checkbox_check', 'data-user' => $model
                                                    ->id, 'data-id' => $value['id']]) . '</span>
                                    </div></div>
                                </div>';
                                    }
                                }
                            }
                            $html .= '</div></div>';
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'trademark',
                        'format' => 'raw',
                        'value' => $model->trademark . '<span class="pull-right">' . $form->field($model, "active[trademark]")->checkbox(['label' => 'Xác thực', 'value' => 1]) . '</span>'
                    ],
                    [
                        'attribute' => 'category',
                        'format' => 'raw',
                        'value' => function ($data, $form) {
                            $arr = [];
                            foreach ($data->category as $key => $value) {
                                $arr[] = '<a href="/category/' . $value['slug'] . '">' . $value['title'] . '</a>';
                            }
                            $html = implode(', ', $arr) . '<input type="hidden" name="User[active][category]" value="0"><span class="pull-right">' . Html::checkbox('User[active][category]', $data->active['category'] == 1 ? TRUE : FALSE, ['label' => 'Xác thực']) . '</span>';
                            return $html;
                        },
                    ],
                    [
                        'attribute' => 'about',
                        'format' => 'raw',
                        'value' => function ($data, $form) {
                            return $data->about;
                        },
                    ],
                    [
                        'attribute' => 'images',
                        'format' => 'raw',
                        'value' => function ($data, $form) {
                            if (!empty($data->images)) {
                                $images = '';
                                foreach ($data->images as $value) {
                                    $images .= '<a href="' . Yii::$app->setting->get('siteurl_cdn') . '/' . $value . '" data-lightbox="roadtrip"><img style="margin-right: 15px;" data-src="' . Yii::$app->setting->get('siteurl_cdn') . '/' . $value . '" src="' . Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $value . '&size=200x280"></a>';
                                }
                            } else {
                                $images = "Chưa có hình ảnh nào";
                            }
                            return $images;
                        },
                    ],
                    [
                        'attribute' => 'output_provided',
                        'format' => 'raw',
                        'value' => $model->output_provided . ' ' . $model->output_provided_unit . '/năm <span class="pull-right">' . $form->field($model, "active[output_provided]")->checkbox(['label' => 'Xác thực']) . '</span>'
                    ],
                    [
                        'attribute' => 'acreage',
                        'format' => 'raw',
                        'value' => $model->acreage . ' ' . $model->acreage_unit . '<span class="pull-right">' . $form->field($model, "active[acreage]")->checkbox(['label' => 'Xác thực']) . '</span>'
                    ],
                    [
                        'attribute' => 'insurance_money',
                        'format' => 'raw',
                        'value' => '<input type="number" name="User[insurance_money]" value="' . $model->insurance_money . '"> <span class="pull-right">' . $form->field($model, "active[insurance_money]")->checkbox(['label' => 'Xác thực']) . '</span>'
                    ],
                    [
                        'attribute' => 'Trạng thái',
                        'format' => 'raw',
                        'value' => $form->field($model, "public")->radioList([1 => 'Duyệt', 2 => 'Không duyệt'])->label(FALSE) . '<div class="reason"></div>'
                    ],
                    [
                        'attribute' => 'Hiển thị',
                        'format' => 'raw',
                        'value' => '<span>' . $form->field($model, "status")->radioList([2 => 'Hiển thị', 3 => 'Không hiển thị'])->label(FALSE) . '</span>'
                    ],
                ],
            ]);
            ?>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success']) ?>

            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Chú ý!</span>',
    'id' => 'modal-seller',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<?php
yii\bootstrap\Modal::end();
?>

<?php ob_start(); ?>
<script>
    $(document).ready(function () {
        $('.checkbox_check').change(function () {
            if (this.checked) {
                id = $(this).data('id');
                $(this).attr('value', 1);
                value = $(this).val();
                idUser = $(this).data('user');
                $.ajax({
                    url: '<?= Yii::$app->urlManager->createUrl(["seller/certificate"]); ?>',
                    type: 'post',
                    data: 'id=' + id + '&idUser=' + idUser + '&value=' + value,
                    success: function (data) {
                    }
                });
            } else {
                id = $(this).data('id');
                $(this).attr('value', 0);
                value = $(this).val();
                idUser = $(this).data('user');
                $.ajax({
                    url: '<?= Yii::$app->urlManager->createUrl(["seller/certificate"]); ?>',
                    type: 'post',
                    data: 'id=' + id + '&idUser=' + idUser + '&value=' + value,
                    success: function (data) {
                    }
                });
            }
        });

        function getReason() {
            var html = '';
<?php
foreach ($reason as $k => $r) {
    ?>
                html += '<div class="checkbox"><label><input type="checkbox" <?= !empty($model->reason) && in_array($r, $model->reason) ? "checked" : "" ?> name="User[reason][]" value="<?= $k ?>"><?= $r ?></label></div>';
    <?php
}
?>
            return html;
        }
        var public = parseInt($('input[name="User[public]"]:checked').val());
        if (public == 2) {
            $(".reason").html(getReason);
        }
        $('#user-public input').change(function () {
            var data = parseInt($(this).val());
            if (data == 2) {
                $(".reason").html(getReason);
            } else {
                $(".reason").html("");
            }

        });
    });

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
        
