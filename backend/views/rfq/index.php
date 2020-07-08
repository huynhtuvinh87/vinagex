<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Báo giá';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="pull-left">
                <a href="javascript:void(0)" class="btn btn-default review_status">Duyệt tất cả đã chọn</a>
            </div>
            <div class="pull-right">
                <?php
                $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'GET',
                            'options' => [
                                'class' => 'form-inline'
                            ]
                ]);
                ?>
                <?= $form->field($search, 'status')->dropDownList($search->status())->label(FALSE) ?>

                <?= $form->field($search, 'keywords')->textInput()->label(FALSE) ?>
                <button type="submit" class="btn btn-default" style="margin-top: -5px;">Tìm kiếm</button>
                <?php ActiveForm::end(); ?>
            </div>

            <?php
            $form = ActiveForm::begin([
                        'id' => 'formStatus',
                        'action' => ['status'],
                        'method' => 'POST',
                        'options' => [
                            'class' => 'form-inline'
                        ]
            ]);
            ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'multiple' => true,
                        'checkboxOptions' => function($model, $key, $index, $widget) {
                            if ($model['status'] == Constant::STATUS_FINISH || $model['status'] == Constant::STATUS_STOP) {
                                $html = ['disabled' => true];
                            } else {
                                $html = ["value" => (string) $model['_id']];
                            }
                            return $html;
                        },
                        'headerOptions' => ['width' => 10],
                    ],
                    [
                        'attribute' => 'Sản phẩm',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<ul>';
                            $html .= '<li>' . $data['title'] . '</li>';
                            $html .= '<li>Số lượng: ' . $data['quantity'] . ' ' . $data['unit'] . '</li>';
                            $html .= '<li>Giá tiền: ' . (!empty($data['price']) ? Constant::price($data['price']) : 'Thỏa thuận') . '</li>';
                            $html .= '<li>Ngày đặt / hết hạn: ' . date('d/m/Y', strtotime($data['date_start'])) . ' - ' . date('d/m/Y', strtotime($data['date_end'])) . '</li>';
                            $html .= '</ul>';
                            return $html;
                        },
                        'headerOptions' => ['width' => 200],
                    ],
                    [
                        'attribute' => 'Nội dung',
                        'format' => 'raw',
                        'value' => function($data) {

                            return $data['content'];
                        },
                    ],
                    [
                        'attribute' => 'Người đặt',
                        'format' => 'raw',
                        'value' => function($data) {
                            return '<a href="' . Yii::$app->setting->get('siteurl') . '/user/view/' . $data['owner']['id'] . '">' . $data['owner']['fullname'] . '</a>';
                        },
                    ],
                    [
                        'attribute' => 'Hình ảnh',
                        'format' => 'raw',
                        'value' => function($data) {
                            if (!empty($data['images'])) {
                                $html = '<ul>';
                                foreach ($data['images'] as $value) {
                                    $html .= '<li style="display:inline-block; margin-right:5px"><a  data-lightbox="' . (string) $data['_id'] . '" href="' . Constant::domain('cdn') . '/' . $value . '"><img width="100" height="80" src="' . Constant::domain('cdn') . '/' . $value . '"></a></li>';
                                }
                                $html .= '</ul>';
                            } else {
                                $html = 'Không có hình ảnh';
                            }
                            return $html;
                        },
                        'headerOptions' => ['width' => 350]
                    ],
                    [
                        'attribute' => 'Trạng thái',
                        'format' => 'raw',
                        'value' => function($data) {
                            if ($data['status'] == Constant::STATUS_FINISH || $data['status'] == Constant::STATUS_STOP) {
                                $html = Constant::STATUS_SHOW_RFQ[$data['status']];
                            } else {
                                $html = Html::dropDownList('status', $data['status'], [
                                            Constant::STATUS_PENDING => 'Duyệt',
                                            Constant::STATUS_NOACTIVE => 'Chưa duyệt',
                                                ], ['class' => 'form-control check-review', 'style' => 'width:150px', 'data-id' => (string) $data['_id']]);
                            }
                            return $html;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{delete}',
                        'buttons' => [
                            //view button
                            'view' => function ($url, $data) {
                                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span>', '/rfq/view/' . (string) $data['_id']);
                            },
                            //view button
                            'delete' => function ($url, $data) {
                                return Html::a(' <span class="glyphicon glyphicon-trash"></span>', '/rfq/delete/' . (string) $data['_id'], [
                                            'title' => 'Xóa',
                                            'data-confirm' => Yii::t('yii', 'Bạn có muốn xoá không?'),
                                            'data-method' => 'post',
                                ]);
                            },
                        ],
                        'headerOptions' => ['width' => 50]
                    ],
                ],
            ]);
            ?>
            <?php ActiveForm::end(); ?>
        </div>

    </div>
</div>
<?= $this->registerJs("
$(document).ready(function() {
    $('form#reviewAction button[type=submit]').click(function() {
         return confirm('Bạn có muốn thực hiện yêu cầu này không?');
    });
});
") ?>

<?php ob_start(); ?>
<script>

    $("body").on("change", ".check-review", function (event) {
        var status = this.value;
        var id = $(this).data('id');
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["rfq/doaction"]); ?>',
            type: 'post',
            data: 'id=' + id + '&status=' + status,
            success: function (data) {
                return false;
            }
        });

    });

    $("body").on("click", ".review_status", function (event) {
        if (confirm('Bạn có muốn duyệt tất cả đã chọn?')) {
            $("#formStatus").submit();
        }
    });

    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
