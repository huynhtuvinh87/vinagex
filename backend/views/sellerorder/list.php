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

        <?php
        Pjax::begin([
            'id' => 'pjax_gridview_order',
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
                    'attribute' => 'code',
                    'format' => 'raw',
                    'value' => function($data) {
                        return '<span class="code">' . $data->code . '</span>';
                    },
                   
                ],
                [
                    'attribute' => 'product_id',
                    'format' => 'raw',
                    'value' => function($data) {
                        return '<a href="/order/view/' . $data->code . '">' . $data->product->title . '</a>';
                    }
                ],
                [
                    'attribute' => 'quantity',
                    'format' => 'raw',
                    'value' => function($data) {
                        return $data->quantity . ' ' . $data->product->unit_of_calculation;
                    }
                ],
                     [
                    'attribute' => 'price',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Constant::price($data->quantity * $data->price);
                    }
                ],
                [
                    'attribute' => 'province_id',
                    'format' => 'raw',
                    'value' => function($data) {
                        return $data->province->name;
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function($data) {
                        return '<span class="code">'.Constant::STATUS_ORDER[$data->status].'<span>';
                    },
                ],
                [
                    'attribute' => 'delivery_date',
                    'format' => 'raw',
                    'value' => function($data) {
                        return \Yii::$app->formatter->asDatetime($data->delivery_date, "php:d/m/Y h:i");
                    }
                ],
              
            ],
        ]);
        ?>
        <?php ActiveForm::end(); ?>
        <?php Pjax::end() ?> 
<?= $this->registerJs("
$(document).ready(function() {
    $('form#orderAction button[type=submit]').click(function() {
        return confirm('Rollback deletion of candidate table?');
    });
});
") ?>
