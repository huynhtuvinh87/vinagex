<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\Constant;

$this->title = 'Đăng ký bán hàng';
?>
<div class="site-signup" style="margin-top: 50px">
    <div class="row">
        <div class="col-sm-8 form-seller col-sm-offset-2">
            <h1 style="font-weight: 300; text-align: center; text-transform: uppercase; margin-bottom: 30px">Đăng ký bán hàng cùng Giá tại vườn</h1>
            <p style="text-align: center; margin-bottom: 50px">Cảm ơn đối tác đã tin tưởng và lựa chọn đồng hành cùng Giataivuon! <br>
                Vui lòng hoàn tất biểu mẫu và cung cấp đầy đủ hồ sơ theo hướng dẫn để có thể bán hàng nhanh nhất.</p>

            <div class="col-sm-offset-2">
                <?php $form = ActiveForm::begin(['id' => 'form-signup', 'layout' => 'horizontal']); ?>
                <h4>Thông tin liên hệ</h4>
                <?= $form->field($model, 'fullname')->textInput()->hint('Người đại diện nhà vườn') ?>
                <?= $form->field($model, 'phone')->textInput()->hint('Số điện thoại liên hệ ') ?>
                <?= $form->field($model, 'email')->textInput()->hint('Dịa chỉ email dùng để trao đổi') ?>

                <h4>Thông tin nhà vườn</h4>
                <?= $form->field($model, 'garden_name')->textInput()->hint('Tên nhà vườn của bạn là gì') ?>
                <?= $form->field($model, 'category')->dropDownList($model->category(), ['class' => 'form-control select2-tag', 'multiple' => TRUE])->hint('Vườn của bạn trồng những loại nào') ?>
                <?= $form->field($model, 'acreage')->textInput(['type' => 'number'])->hint('Quy mô của vườn bạn bao nhiêu ha') ?>
                <?= $form->field($model, 'address')->textInput(['id' => 'map-address'])->hint('Địa chỉ nhà vườn của bạn') ?>
                <?= $form->field($model, 'province_id')->dropDownList(Constant::province(), ['prompt' => 'Chọn tỉnh thành', 'class' => 'select2-select']) ?>
                <div class="form-group">
                    <?= Html::hiddenInput('SellerForm[lat]', $model->lat, ['id' => 'lat']) ?>
                    <?= Html::hiddenInput('SellerForm[long]', $model->long, ['id' => 'long']) ?>
                    <div id="map" style="display:none"></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-6 col-sm-offset-3">
                        <?= Html::submitButton('Đăng ký', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?=
$this->registerJs("
    $('.select2-tag').select2({
    tags: true,
    tokenSeparators: [',', ' '],
    createTag: function(params) {
        return undefined;
    }
});

");
$this->registerJsFile(
        '/js/google-map.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyA60bEEA8Yjn_RHBFpS-Zeh5wiXG7NhAyM&libraries=places&callback=initAutocomplete', ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>