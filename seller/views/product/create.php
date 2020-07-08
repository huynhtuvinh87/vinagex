<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */
$this->title = 'Thêm mới sản phẩm';
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= $this->render('_form', ['model' => $model]) ?>
