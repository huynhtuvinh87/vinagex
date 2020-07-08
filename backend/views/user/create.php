<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */
$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Danh sách', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


       <div class="x_panel">

                <div class="x_content">
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-2',
                            'offset' => 'col-sm-offset-2',
                            'wrapper' => ' col-md-4 col-sm-4 col-xs-12',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],
        ]);
        ?>  
        <?= $form->field($model, 'fullname')->textInput() ?>
        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>



        <div class="form-group">
            <div class="col-md-offset-2 col-md-6 col-sm-9 col-xs-12">
                <?= Html::submitButton('Thêm', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>
