<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Cập nhật: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Danh mục', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="category-update">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?php
            $form = ActiveForm::begin([
                        'layout' => 'horizontal',
                        'options' => ['enctype' => 'multipart/form-data'],
                        'fieldConfig' => [
                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                            'horizontalCssClasses' => [
                                'label' => 'col-sm-2',
                                'offset' => 'col-sm-offset-2',
                                'wrapper' => ' col-md-10 col-sm-10 col-xs-12',
                                'error' => '',
                                'hint' => '',
                            ],
                        ],
            ]);
            ?>  
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-6 col-sm-9 col-xs-12">
                    <?= Html::submitButton($model->isNewRecord ? 'Thêm mới' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>


    </div>
</div>
<?=
$this->registerJs("
$(document).ready(function () {
        $('.select2-tag').select2({
        tags: true,
    });
     });
");
?>
