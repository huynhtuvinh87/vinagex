<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\components\Constant;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="form-signup">
        <div class="row">
            <div class="col-lg-12">
                <?php
                Pjax::begin([
                    'id' => 'pjax_gridview_history',
                ])
                ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                        [
                            'attribute' => 'product_province_id',
                            'format' => 'raw',
                            'value' => function($data) {
                                $html = '<a href="/' . $data->product->product_slug . '-' . $data->product->id . '">' . $data->product->product_name . '</a><br>';
                                $html .= '<a href="/customer/message?id=' . $data->id .'" class="btn btn-default btn-small">Chat với nhà vườn</a>';
                                return $html;
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
                <?php Pjax::end() ?> 
            </div>

        </div>
    </div>
</div>