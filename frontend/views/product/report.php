<?php

use yii\bootstrap\ActiveForm;
?>


<?php
$form = ActiveForm::begin([
            'id' => 'report-form'
        ]);
?>
<h5>Sản phẩm này có vấn đề gì vậy?</h5>
<?= $form->field($model, 'reason[]')->checkboxList($model->status())->label(FALSE) ?>
<?= $form->field($model, 'description')->textarea(['placeholder'=>'Hãy cho chúng tôi biết thêm thông tin']) ?>
<?php if (\Yii::$app->user->isGuest) { ?>
	<?= $form->field($model, 'email')->textInput() ?>
	<?= $form->field($model, 'phone')->textInput() ?>
<?php } ?>
<?php ActiveForm::end(); ?>
