<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = 'Thêm mới';
$this->params['breadcrumbs'][] = ['label' => 'Chứng nhận', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slide-create">
    <div class="row">
        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>
    </div>
</div>