<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chọn tỉnh thành</h4>
            </div>
            <div class="modal-body text-center">
                <?php $form = ActiveForm::begin(['action' => '/site/province']); ?>
                <div style="margin: 0 auto">
                    <p>Hãy chọn tỉnh thành của bạn. Bạn có thể thay đổi tỉnh thành tại đầu trang.</p>
                    <?=$form->field($model, 'url')->hiddenInput()->label(FALSE)?>
                    <?= Html::dropDownList('City[province_id]', Yii::$app->city->get(), $model->province, ['class' => 'form-control select2-select', 'style' => "display: inline-block; width:300px; text-align:left", 'id' => 'top-province']) ?>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Đồng ý" style="width: 300px; padding: 10px 0; margin-top: 20px; text-transform: uppercase; font-weight: 400; font-size: 16px">
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>

    </div>
</div>