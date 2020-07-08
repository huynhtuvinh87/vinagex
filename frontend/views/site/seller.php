<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\Constant;

$this->title = 'Đăng ký bán hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-sm-6 form-seller">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <h4>Thông tin liên hệ</h4>
            <?= $form->field($model, 'fullname')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <h4>Thông tin đăng nhập</h4>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <h4>Thông tin nhà vườn</h4>
            <?= $form->field($model, 'garden_name')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'product_provided')->dropDownList(Constant::category_sub(), ['class' => 'form-control select2-tag', 'multiple' => TRUE]) ?>
            <?= $form->field($model, 'address')->textInput(['id' => 'map-address']) ?>
            <?= $form->field($model, 'province_id')->dropDownList(Constant::province(), ['prompt' => 'Chọn tỉnh thành','class'=>'select2-select']) ?>

            <div class="form-group">
                <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?=
$this->registerJs("
    $('.select2-tag').select2({
    tags: true,
    tokenSeparators: [',', ' ']
});

");
$this->registerJsFile(
        '/js/google-map.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyA60bEEA8Yjn_RHBFpS-Zeh5wiXG7NhAyM&libraries=places&callback=initAutocomplete', ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>