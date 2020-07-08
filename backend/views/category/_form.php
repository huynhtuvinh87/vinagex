<?php

use yii\helpers\Html;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>



<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
<?=
$form->field($model, 'parent_id')->dropDownList(Constant::category(), ['class' => 'form-control select2-select', 'prompt' => 'Chọn danh mục']);
?>
<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
<div class="form-group">
    <div class="col-md-offset-3 col-md-6 col-sm-9 col-xs-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
