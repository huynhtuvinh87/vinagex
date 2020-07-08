<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$this->title = \Yii::t('app', 'Update') . ": " . $model->firstname . ' ' . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->firstname . ' ' . $model->lastname, 'url' => ['assignment/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = \Yii::t('app', 'Update');
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
                            'wrapper' => ' col-md-10 col-sm-10 col-xs-12',
                            'error' => '',
                            'hint' => '',
                        ],
                    ],
        ]);
        ?>  

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'email')->textInput() ?>

        <?= $form->field($model, 'firstname')->textInput() ?>

        <?= $form->field($model, 'lastname')->textInput() ?>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-6 col-sm-9 col-xs-12">
                <?= Html::submitButton(\Yii::t('app', 'Update'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>
