<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = 'Thay đổi mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$form = ActiveForm::begin(['layout' => 'horizontal']);
?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_new')->passwordInput() ?>
<?= $form->field($model, 'password_rep')->passwordInput() ?>

<div class="form-group">
    <div class='col-sm-8 col-sm-offset-3'>
        <button class="btn btn-primary"><?= $this->title ?></button>
    </div>
</div>

<?php ActiveForm::end(); ?>
