<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đánh giá';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="pull-left">
                <a href="javascript:void(0)" class="review_status">Chọn và duyệt tất cả</a>
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
                <button type="submit" class="btn btn-default" style="margin-top: -5px;">Áp dụng</button>
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
                        'headerOptions' => ['width' => 10]
                    ],
                    [
                        'attribute' => 'product_id',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data['product']['title'];
                        },
                    ],
                    'ip',
                    [
                        'attribute' => 'Họ tên',
                        'format' => 'raw',
                        'value' => function($data) {

                            return $data['actor']['fullname'];
                        },
                    ],
                    [
                        'attribute' => 'content',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->content;
                        },
                    ],
                    [
                        'attribute' => 'star',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->star;
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::dropDownList('status', $data->status, $data->status(), ['class' => 'form-control check-review', 'style' => 'width:150px', 'data-id' => $data->id]);
                        },
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
            url: '<?= Yii::$app->urlManager->createUrl(["review/doaction"]); ?>',
            type: 'post',
            data: 'id=' + id + '&status=' + status,
            success: function (data) {
                return false;
            }
        });

    });

    $("body").on("click", ".review_status", function (event) {
        $("#formStatus").submit();
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
