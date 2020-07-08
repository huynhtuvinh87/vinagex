<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Đơn hàng';
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
                <?= $form->field($search, 'status')->dropDownList(Constant::STATUS_ORDER)->label(FALSE) ?>

                <?= $form->field($search, 'keywords')->textInput()->label(FALSE) ?>
                <button type="submit" class="btn btn-default" style="margin-top: -5px;"><?= Yii::t('app', 'Search') ?></button>
                <?php ActiveForm::end(); ?>
            </div>

            <?php
            Pjax::begin([
                'id' => 'pjax_gridview_page',
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

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                    [
                        'attribute' => 'Mã đơn hàng',
                        'format' => 'raw',
                        'value' => function($data) {
                            return '<a class="code" href="#">' . $data->invoice_code . '</a>';
                        },
                    ],
                    [
                        'attribute' => 'Thông tin người mua',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<ul>';
                            $html .= '<li>Họ tên: ' . $data->name . '</li>';
                            $html .= '<li>Điện thoại: ' . $data->phone . '</li>';
                            $html .= '<li>Địa chỉ: ' . $data->address . '</li>';
                            $html .= '</ul>';
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'Thông tin đơn hàng',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<ul>';
                            foreach ($data->products as $k => $value) {
                                $html .= '<li>' . ($k + 1) . '. ' . $value['title'] . ': ' . $value['quantity'] . ' x ' . Constant::price($value['price']) . '</li>';
                            }
                            $html .= '</ul>';
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'total',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Constant::price($data->total);
                        }
                    ],
                    'note',
                    [
                        'attribute' => 'created_at',
                        'format' => 'raw',
                        'value' => function($data) {
                            return date('d/m/Y', $data->created_at);
                        }
                    ],
                    [
                        'attribute' => 'delivery_date',
                        'format' => 'raw',
                        'value' => function($data) {
                            return \Yii::$app->formatter->asDatetime($data->delivery_date, "php:d/m/Y") . ' ' . $data->time;
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
        return confirm('Rollback deletion of candidate table?');
    });
});
") ?>
