<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use common\components\Constant;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h2><?= Html::encode($this->title) ?></h2>
    <div class="row">

        <div class="col-sm-12 panel-view-order">

            <?php
            foreach ($model->products as $value) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-body" style="padding:5px 15px">
                        <div class="row">
                            <div class="col-sm-3">
                                <h4 style="border-bottom: 1px solid #ddd; padding-bottom: 10px">Thộng tin sản phẩm</h4>
                                <p>Tên sản phẩm: <?= $value['title'] ?></p>
                                <p>Số lượng: <?= $value['quantity'] ?></p>
                                <p>Giá: <?= $value['price'] ?></p>
                            </div>
                            <div class="col-sm-3">
                                <h4 style="border-bottom: 1px solid #ddd; padding-bottom: 10px">Địa chỉ người giao</h4>
                                <p>Họ tên: <?= $value['owner_info']['fullname'] ?></p>
                                <p>Địa chỉ: <?= $value['owner_info']['address'] ?>, <?= $value['owner_info']['ward']['name'] ?>, <?= $value['owner_info']['district']['name'] ?>, <?= $value['owner_info']['province']['name'] ?></p>
                            </div>
                            <div class="col-sm-3">
                                <h4 style="border-bottom: 1px solid #ddd; padding-bottom: 10px">Địa chỉ người nhận</h4>
                                <p><?= $model->name ?></p>
                                <p>Điện thoại: <?= $model->phone ?></p>
                                <p>Địa chỉ: <?= $model->address ?>, <?= $model->ward ?>, <?= $model->district ?>, <?= $model->province ?></p>
                            </div>
                            <div class="col-sm-3">
                                <h4 style="border-bottom: 1px solid #ddd; padding-bottom: 10px">Hình thức thanh toán</h4>
                                <p><?= Constant::CHECKOUT_PAYMENTS[$model->payments] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>
</div>