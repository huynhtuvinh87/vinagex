<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\AuthItem */
/* @var $context mdm\admin\components\ItemController */

$this->title = \Yii::t('app', 'Update information');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
?>
<div class="user-update">
    <div class="auth-item-form">
        <?php $form = ActiveForm::begin(['id' => 'profile-form']); ?>
        <p>
            <?= Html::a(\Yii::t('app', 'Change the password'), ['changepassword'], ['class' => 'btn btn-success pull-right']) ?>
        </p>
        <div class="x_content"
             <div class="row">
                <div class="col-sm-6">
                
                    <?= $form->field($model, 'id')->hiddenInput()->label(FALSE) ?>

                    <?= $form->field($model, 'email')->textInput() ?>

                    <?= $form->field($model, 'firstname')->textInput() ?>

                    <?= $form->field($model, 'lastname')->textInput() ?>

                    <?= Html::submitButton($this->title, ['class' => 'btn btn-primary', 'name' => 'profile-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>


    </div>

</div>
