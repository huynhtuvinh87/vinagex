<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

$this->title = 'Thay đổi mật khẩu';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- delete-page -->
<section class="clearfix job-bg  ad-profile-page">
    <div class="container">

        <div class="profile job-profile">
            <div class="user-pro-section">
                <?php
                $form = ActiveForm::begin();
                ?>
                <div class="profile-details section">
                    <h2><?= $this->title ?></h2>
                    <?= Alert::widget() ?>
                    <?=
                    $form->field($model, 'password', [
                        'options'  => ['class' => 'form-group row'],
                        "template" => "<label class=\"col-sm-3\">" . $model->getAttributeLabel('password') . "</label><div class='col-sm-8'>\n{input}\n{hint}\n{error}</div>"
                    ])->passwordInput()
                    ?>
                    <?=
                    $form->field($model, 'password_new', [
                        'options'  => ['class' => 'form-group row'],
                        "template" => "<label class=\"col-sm-3\">" . $model->getAttributeLabel('password_new') . "</label><div class='col-sm-8'>\n{input}\n{hint}\n{error}</div>"
                    ])->passwordInput()
                    ?>
                    <?=
                    $form->field($model, 'password_rep', [
                        'options'  => ['class' => 'form-group row'],
                        "template" => "<label class=\"col-sm-3\">" . $model->getAttributeLabel('password_rep') . "</label><div class='col-sm-8'>\n{input}\n{hint}\n{error}</div>"
                    ])->passwordInput()
                    ?>

                    <div class="form-group">
                        <div class='col-sm-8 col-sm-offset-3'>
                            <button class="btn btn-primary"><?= $this->title ?></button>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>			
        </div>
    </div><!-- container -->
</section><!-- delete-page -->
