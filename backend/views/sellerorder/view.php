<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use common\components\Constant;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->params['breadcrumbs'][] = ['label' => 'Đơn hàng', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <div class="row">
        <div class="col-sm-3 panel-view-order">
            <h3>Địa chỉ người nhận</h3>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><?= $model->name ?></h4>
                    <p>Địa chỉ: <?= $model->address ?></p>
                    <p>Điện thoại: <?= $model->phone ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 panel-view-order">
            <h3>Hình thức giao hàng</h3>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4><?= $model->name ?></h4>
                    <p>Địa chỉ: <?= $model->address ?></p>
                    <p>Điện thoại: <?= $model->phone ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3 panel-view-order">
            <h3>Hình thức thanh toán</h3>
            <div class="panel panel-default">
                <div class="panel-body">
                    <p><?= Constant::CHECKOUT_PAYMENTS[$model->payments] ?></p>
                </div>
            </div>
        </div>
        <div class="col-sm-3" style="margin-top: 80px;">
            <div class="dropdown-order pull-right">
                <button class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown"><?= Constant::STATUS_ORDER[$model->status] ?>
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <?php
                    foreach (Constant::STATUS_ORDER as $key => $value) {
                        ?>
                        <li><a href="/order/status/<?=$model->code?>?key=<?=$key?>"><?= $value ?></a></li>
                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
        <div class="col-sm-12 panel-view-order">

            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    Pjax::begin([
                        'id' => 'pjax_gridview_product',
                    ])
                    ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ['class' => 'table table-striped table-product'],
                        'layout' => "{items}\n{summary}\n{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                            [
                                'attribute' => 'Sản phẩm',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return '<div class="media">
                                        <div class="media-left">
                                          <a href="#">
                                            <img src="http://giataivuon.loc' . explode(',', $data->product->images)[0] . '" width=50>
                                          </a>
                                        </div>
                                        <div class="media-body">
                                          <h5 class="media-heading">' . $data->product->title . '</h5>
                                          <p>' . $data->product->user->userSeller->garden_name . '<p>
                                       </div>
                                      </div>';
                                },
                                'headerOptions' => ['width' => 400]
                            ],
                            [
                                'attribute' => 'Giá',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return Constant::price($data->price);
                                }
                            ],
                            [
                                'attribute' => 'Số lượng',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return $data->quantity;
                                }
                            ],
                            [
                                'attribute' => 'Đơn vị tính',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return $data->product->unit_of_calculation;
                                }
                            ],
                            [
                                'attribute' => 'Tạm tính',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return Constant::price($data->price * $data->quantity);
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
</div>