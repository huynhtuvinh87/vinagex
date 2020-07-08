<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use common\components\Constant;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Đơn hàng', 'url' => ['order']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signup">
    <div class="row">

        <div class="col-sm-4 col-sm-offset-4">

            <div class="panel panel-default" style="margin-top: 30%">
                <div class="panel-body text-center">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'status')->hiddenInput(['value' => $key])->label(FALSE) ?> 
                    Đơn hàng này trong quá trình <strong class="text-danger"><?= Constant::STATUS_ORDER[$model->status] ?></strong>. Bạn có muốn chắc chyển sang trạng thái <strong class="text-success"><?= Constant::STATUS_ORDER[$key] ?></strong> không?
                    <div class="form-group" style="margin-top: 30px">
                        <input type="submit" value="Đồng ý" class="btn btn-success">
                        <a href="/order/view/<?=$model->code?>" class="btn btn-danger">Huỷ</a>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>