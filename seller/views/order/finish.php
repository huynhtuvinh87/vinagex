<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<h4><b>Thông tin khách hàng</b></h4>
<p>Tên khách hàng: <b><?= $order['buyer']['name']?></b></p>
<p>SĐT: <b><?= $order['buyer']['phone']?></b></p>
<p>Địa chỉ: <b><?= $order['buyer']['address'].', '.$order['buyer']['ward'].', '.$order['buyer']['district'].', '.$order['buyer']['province'] ?></b></p>
<br>
<?php $form = ActiveForm::begin(['id' => 'order-form','enableAjaxValidation' => true]) ?>
<h4><b>Mức độ hài lòng về khách hàng của bạn </b></h4>
<div class="btn-group radio-review" data-toggle="buttons">
    <label style="margin-right: 10px;" class="btn btn-success form-check-label">
        <input class="form-check-input" type="radio" name="OrderForm[level_satisfaction]" id="option1" autocomplete="off" value="1"><p style="margin: 0"><i style="font-size: 20px" class="fas fa-smile"></i> Hài lòng</p>

    </label>
    <label style="margin-right: 10px;" class="btn btn-primary form-check-label">
        <input class="form-check-input" type="radio" name="OrderForm[level_satisfaction]" id="option2" autocomplete="off" value="2"><p style="margin: 0"><i style="font-size: 20px" class="fas fa-meh"></i> Bình thường</p>
    </label>
    <label class="btn btn-danger form-check-label">
        <input class="form-check-input" type="radio" name="OrderForm[level_satisfaction]" id="option3" autocomplete="off" value="3"><p style="margin: 0"><i style="font-size: 20px" class="fas fa-frown"></i> Không hài lòng</p>
    </label>
</div>
<?= $form->field($model, 'description')->textArea(['placeholder'=>'Nhập đánh gía ...'])->label('Đánh gía của bạn') ?>
 <?php ActiveForm::end(); ?>