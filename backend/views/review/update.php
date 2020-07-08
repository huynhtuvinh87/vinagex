<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Order'), 'url' => ['index']];
$this->params['breadcrumbs'][] = \Yii::t('app', 'Update');
?>
<div class="order-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
    <div class="row">
        <div class="col-xs-12">      
            <div class="x_title">
                Thông tin sản phẩm
            </div>
            <div class="x_panel">
                <?=
                GridView::widget([
                    'dataProvider' => $products,
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                        [
                            'attribute' => 'image',
                            'format' => 'raw',
                            'value' => function($data) {
                                return '<img width="100" src="' . $data['image'] . '" alt="">';
                            },
                            'headerOptions' => ['width' => 100]
                        ],
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function($data) {
                                return '<a target="_bank" href="' . $data['url'] . '">' . $data['name'] . '</a>';
                            },
                        ],
                        'size',
                        'color',
                        'quantity',
                        'price',
                        [
                            'attribute' => 'created_at',
                            'format' => 'raw',
                            'value' => function($data) {
                                return date('d/m/Y', $data['created_at']);
                            }
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
