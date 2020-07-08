<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="form-group">
    <label><b>Tên sản phẩm:</b> <?= $model['title'] ?></label>
 </div>
<div class="form-group">
  <label for="Nội dung"><b>Lý do:</b></label>
  	<?php 
	  	foreach ($model['note_cancel'] as $value) {
	  		echo "<p>- ".$model->getError()[$value]."</p>";
	  	}
   ?>
</div>