<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use common\widgets\Alert;
use yii\helpers\Html;

$this->title = \Yii::t('common', 'Thay đổi mật khẩu');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- delete-page -->
<div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <?php
        $form = ActiveForm::begin();
        ?>
        <DIV class="row">
            <div class="col-lg-6">

                <?=
                $form->field($model, 'password')->passwordInput()->label(\Yii::t('common', 'Mật khẩu'))
                ?>
                <?=
                $form->field($model, 'password_new')->passwordInput()->label(\Yii::t('common', 'Mật khẩu mới'))
                ?>
                <?=
                $form->field($model, 'password_rep')->passwordInput()->label(\Yii::t('common', 'Nhập lại mật khẩu'))
                ?>

                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('common', 'Cập nhật'), ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>			
</div>