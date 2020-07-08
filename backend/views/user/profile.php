<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$this->title = 'Cập nhật';
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-update">
    <div class="auth-item-form">
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'label' => 'col-sm-2',
                            'offset' => 'col-sm-offset-2',
                            'wrapper' => ' col-md-6 col-sm-6 col-xs-12',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],
        ]);
        ?>  
        <div class="x_panel">

            <div class="x_content">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'id')->hiddenInput()->label(FALSE) ?>
                        <?= $form->field($model, 'fullname')->textInput() ?>
                        <?= $form->field($model, 'username')->textInput() ?>
                        <?= $form->field($model, 'email')->textInput() ?>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6 col-sm-9 col-xs-12">
                                <?= Html::submitButton($this->title, ['class' => 'btn btn-primary', 'name' => 'profile-button']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>

</div>
