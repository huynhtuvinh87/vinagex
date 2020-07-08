<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;
use common\widgets\Alert;
use common\components\Constant;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Sản phẩm', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$images = $model->images;
?>
<div class="row">
    <div class="col-sm-4">
        <div class="product-img" style="width: auto">
            <img src="<?= $model->images[0]['size_450'] ?>">
        </div>
    </div>
    <div class="col-sm-8">  
        <p>Số lượng tối thiểu: <?= $model->quantity['minimum'] ?>/<?= $model->quantity['maximum'] ?> <?= $model->unit_of_calculation['use'] ?></p>
        <p> <span id="product_countdown" style="font-size: 24px"></span></p>
        <p>
            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(["product/update/" . $model->id]) ?>" class="btn btn-success pull-left" style="margin-right: 10px">Cập nhật</a> 
            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(["product/price/" . $model->id . '?province=' . $model->province[0]['id']]) ?>" class="btn btn-primary pull-left">Chỉnh sửa giá</a>
        </p>
    </div>
</div>


<?=
$this->registerJs("
    CountDownTimer('" . $model->time_end . "', 'product_countdown');
");
?>