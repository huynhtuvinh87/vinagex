<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
 $this->title = 'Nhận báo giá';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
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
                <button type="submit" class="btn btn-success" style="margin-top: -5px;">Tìm kiếm</button>
                <?php ActiveForm::end(); ?>
            </div>
            <?php
            Pjax::begin([
                'id' => 'pjax_gridview_customer',
            ])
            ?>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'orderAction',
                        'action' => ['doaction'],
                        'options' => [
                            'class' => 'form-inline'
                        ]
            ]);
            ?>
            <div class="pull-left">
                <div class="form-group" style="margin-bottom: 5px">
                    <select name="action" class="form-control">
                        <option>Hành động</option>
                        <option value="delete">Xoá</option>
                        <option value="change">Chỉnh sửa</option>
                    </select>
                </div>
                <button type="submit" id="doaction" class="btn btn-success">Áp dụng</button>

            </div>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'multiple' => true,
                    ],
                    [
                        'attribute' => 'product_province_id',
                        'format' => 'raw',
                        'value' => function($data) {
                            return '<a href="/' . $data->product->product_slug . '-' . $data->product->id . '">' . $data->product->product_name . '</a>';
                        }
                    ],
                    [
                        'attribute' => 'quantity',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->quantity . ' ' . $data->product->product_unit_of_calculation;
                        }
                    ],
                    [
                        'attribute' => 'seller_id',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->seller->garden_name . '<br>' . $data->seller->email . '<br>' . $data->seller->phone;
                        }
                    ],
                    'email',
                    'phone',
                    'content',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::dropDownList('status[' . $data->id . ']', $data->status, $data->status(), ['class' => 'form-control']);
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw',
                        'value' => function($data) {
                            return date('d/m/Y', $data->created_at);
                        }
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
    $('form#orderAction button[type=submit]').click(function() {
        return confirm('Bạn có muốn thực hiện yêu cầu này không?');
    });
});
") ?>
