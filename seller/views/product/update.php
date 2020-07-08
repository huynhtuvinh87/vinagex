<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use common\widgets\Alert;
$this->title = 'Chỉnh sửa sản phẩm';
$this->params['breadcrumbs'][] = ['label'=>'Sản phẩm','url'=>['index']];
$this->params['breadcrumbs'][] = ['label'=>'Chi tiết','url'=>['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', ['model' => $model]) ?>
