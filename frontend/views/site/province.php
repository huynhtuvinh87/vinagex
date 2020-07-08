<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use common\components\Constant;
?>
<div class="bg-home">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <h1>Bạn muốn mua ở đâu?</h1>
                <?= Html::dropDownList('province_id', Yii::$app->city->get(), Constant::province(), ['class' => 'form-control select2-select', 'style' => "display: inline-block;", 'id' => 'top-province', 'prompt' => 'Toàn quốc']) ?>
            </div>
        </div>
    </div>
</div>
