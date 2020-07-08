<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */
$this->title = 'Chỉnh sửa';
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= $this->render('_form', ['model' => $model]) ?>