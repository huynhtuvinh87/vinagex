<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = 'Cấu hình';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-form">

    <?php
    $form = ActiveForm::begin(['layout' => 'horizontal']);
    ?>  

    <div class="row">
        <div class="col-md-6">
            <div class="x_title">
                Thông tin cơ bản
            </div>
            <div class="x_panel">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>
                <?= $form->field($model, 'email')->textInput() ?>
                <?= $form->field($model, 'address')->textInput() ?>
                <?= $form->field($model, 'copyright')->textInput() ?>
                <?= $form->field($model, 'siteurl')->textInput() ?>
                <?= $form->field($model, 'siteurl_id')->textInput() ?>
                <?= $form->field($model, 'siteurl_backend')->textInput() ?>
                <?= $form->field($model, 'siteurl_seller')->textInput() ?>
                <?= $form->field($model, 'siteurl_transport')->textInput() ?>
                <?= $form->field($model, 'siteurl_cdn')->textInput() ?>
                <?= $form->field($model, 'siteurl_message')->textInput() ?>
                <?= $form->field($model, 'description')->textarea() ?>
            </div>


        </div>
        <div class="col-md-6">
            <div class="x_title">
                Cấu hình email
            </div>
            <div class="x_panel">
                <?= $form->field($model, 'smtp_host')->textInput() ?>
                <?= $form->field($model, 'smtp_port')->textInput() ?>
                <?= $form->field($model, 'smtp_username')->textInput() ?> 
                <?= $form->field($model, 'smtp_password')->textInput() ?> 
                <?= $form->field($model, 'smtp_encryption')->textInput() ?>
            </div>


        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(($model->isNewRecord) ? \Yii::t('app', 'Lưu') : \Yii::t('app', 'Update'), ['class' => ($model->isNewRecord) ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>
    <?php ActiveForm::end(); ?>
</div>