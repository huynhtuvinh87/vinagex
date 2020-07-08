<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?=

$form->field($model, 'price', [
    'template' => '<label class="control-label col-sm-3  col-xs-6">Giá sản phẩm</label><div class="col-sm-3 col-xs-6">{input}{error}{hint}</div>',
])->textInput(['class' => 'form-control', 'value' => $model->price, 'type' => 'number'])
?>
<?=

$form->field($model, 'quantity_min', [
    'template' => '<label class="control-label col-sm-3 col-xs-6">Số lượng mua tối thiểu</label><div class="col-sm-3 col-xs-6">{input}{error}{hint}</div>',
])->textInput(['class' => 'form-control', "type" => "number"])
?>
<?=

$form->field($model, 'quantity_stock', [
    'template' => '<label class="control-label col-sm-3  col-xs-6">Số lượng có trong kho</label><div class="col-sm-3 col-xs-6">{input}{error}{hint}</div>',
])->textInput(['class' => 'form-control', "type" => "number"])
?>