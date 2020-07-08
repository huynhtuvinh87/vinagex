<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;
use common\components\Constant;

$this->title = 'Cập nhật tài khoản';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <?= Alert::widget() ?>
    <div class="row">
        <div class="col-sm-3">
            <ul class="list-group">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Morbi leo risus</li>
                <li class="list-group-item">Porta ac consectetur ac</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>
        <div class="col-sm-9">
            <?php $form = ActiveForm::begin(['id' => 'profile-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
            <!-- profile-details -->
            <div class="profile-details section">
                <h2>Cập nhật thông tin cá nhân</h2>
                <div class="row form-group">
                    <label class="col-sm-3 label-title" for="profileform-avatar"><?= $model->getAttributeLabel('avatar') ?></label>
                    <div class="col-sm-9">
                        <label for="avatar">
                            <?= Html::fileInput('ProfileForm[avatar]', '', ['style' => 'display:none', 'id' => 'avatar']) ?>
                            <img src="<?= $model->avatar ?>" class="img-thumbnail" id="rs-avatar" style="max-width:200px">
                        </label>
                    </div>
                </div>
                <?=
                $form->field($model, 'fullname', [
                    'options' => ['class' => 'form-group row'],
                    "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('fullname') . "</label><div class='col-sm-9'>\n{input}\n{hint}\n{error}</div>"
                ])
                ?>
                <?=
                $form->field($model, 'birthday', [
                    'options' => ['class' => 'form-group row'],
                    "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('birthday') . "</label><div class='col-sm-9'>\n{input}\n{hint}\n{error}</div>"
                ])
                ?>

                <div class="row form-group">
                    <label class="col-sm-3 label-title" for="profileform-gender"><?= $model->getAttributeLabel('gender') ?></label>
                    <div class="col-sm-9">
                        <?= Html::dropDownList('ProfileForm[gender]', $model->gender, Constant::GENDER, ['class' => 'form-control']) ?>
                    </div>
                </div>
                <?=
                $form->field($model, 'phone', [
                    'options' => ['class' => 'form-group row'],
                    "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('phone') . "</label><div class='col-sm-9'>\n{input}\n{hint}\n{error}</div>"
                ])
                ?>
                <div class="row form-group">
                    <label class="col-sm-3 label-title" for="profileform-level"><?= $model->getAttributeLabel('level') ?></label>
                    <div class="col-sm-9">
                        <?= Html::dropDownList('ProfileForm[level]', $model->level, Constant::LEVEL, ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-3 label-title"><?= $model->getAttributeLabel('city_id') ?></label>
                    <div class="col-sm-9">
                        <?= Html::dropDownList('ProfileForm[city_id]', $model->city_id, Constant::city(), ['class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <button  class="btn btn-success">Cập nhật</button>
                    </div>												
                </div><!-- preferences-settings -->
            </div><!-- profile-details -->

            <?php ActiveForm::end(); ?>	
        </div><!-- user-pro-edit -->
    </div>
</div>


<?=
$this->registerJs("
$(document).ready(function () {
        $(document).on('change', '#avatar', function () {
            readURL(this, '#rs-avatar');
        });
        function readURL(input, id_show) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(id_show).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    });
");
?>