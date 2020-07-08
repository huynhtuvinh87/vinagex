<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin([]) ?>
    <div class="row">
    	<div class="col-xs-12 col-sm-12">
	     	Bạn có chắc muốn xóa tài khoản <b><?= $bank['account_name']?></b> ngân hàng <b><?= $bank['name_bank']?></b> ?<br>
        	<?= Html::submitButton('Đồng ý' , ['class' => 'btn btn-danger pull-right']); ?>
        </div>
     </div>
    <?php ActiveForm::end(); ?>
   

