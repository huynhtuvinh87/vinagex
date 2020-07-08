<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Html::encode($exception->getMessage());
?>
<div class="site-error">
        <?= Html::encode($exception->getMessage()) ?>
</div>