<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\Constant;

$this->title = \Yii::t('common', 'Thông tin cá nhân');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default page-profile">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <?php
        $form = ActiveForm::begin([
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'horizontalCssClasses' => [
                            'label' => 'col-xs-3 col-sm-3 col-full-mobile',
                            'offset' => 'col-sm-offset-3',
                            'wrapper' => 'col-xs-6 col-sm-6 col-full-mobile',
                        ],
                    ],
        ]);
        ?>
        <p><?= \Yii::t('common', 'Để tăng độ tin cậy khi giao dịch mua bán, để giao dịch mua bán dễ dàng hơn vui lòng cập nhật thêm thông tin.') ?></p>

        <div class="form-group field-profileform-avatar">
            <label class="control-label col-xs-3 col-sm-3 col-full-mobile" for="profileform-avatar"><?= \Yii::t('common', 'Ảnh đại diện') ?></label>
            <div class="col-img-avartar">
                <label for="upload-avatar">
                    <input type="file" id="upload-avatar" onchange="uploadAvatar(this);" style="display: none">
                    <img class="avatar" style="margin-bottom:10px; cursor: pointer" class="img-responsive" src="<?= !empty($model->avatar) ? Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $model->avatar . '&size=200x200&time='. time() : Yii::$app->setting->get('siteurl_cdn') . "/image.php?src=images/default.gif&size=200x200" ?>" id="rs-avatar">
                </label>
            </div>
        </div>
        <?= $form->field($model, 'fullname')->textInput()->label(\Yii::t('common', 'Họ và tên')) ?>
        <?=
        $form->field($model, 'email', [
            'template' => "{label}<div class='col-xs-6 col-sm-6 col-full-mobile'>{input}{error}</div><div class='col-xs-3 col-sm-3 col-full-mobile'> <div class='col-checkbox'>
        <div class='checkbox'>
        <label for='profileform-display-email'>
            <input type='hidden' name='ProfileForm[display][email]'' value='0'>
            <input " . ($model['display']['email'] == 1 ? 'checked' : '') . " type='checkbox' id='profileform-display-email' name='ProfileForm[display][email]' value='1'>
         <span class='text-success'>".\Yii::t('common', 'Công khai')."</span>
        </label>
        </div>
        </div></div>"
        ])->textInput()
        ?>
        <?=
        $form->field($model, 'phone', [
            'template' => "{label}<div class='col-xs-6 col-sm-6 col-full-mobile'>{input}{error}</div><div class='col-xs-3 col-sm-3 col-full-mobile'> <div class='col-checkbox'>
        <div class='checkbox'>
        <label for='profileform-display-phone'>
            <input type='hidden' name='ProfileForm[display][phone]'' value='0'>
            <input " . ($model['display']['phone'] == 1 ? 'checked' : '') . " type='checkbox' id='profileform-display-phone' name='ProfileForm[display][phone]' value='1'>
        <span class='text-success'>".\Yii::t('common', 'Công khai')."</span>
        </label>
        </div>
        </div></div>"
        ])->textInput()->label(\Yii::t('common', 'Số điện thoại'))
        ?>


        <div class="form-group field-profileform-province required">
            <label class="control-label col-xs-3 col-sm-3 col-full-mobile" for="profileform-province"><?= \Yii::t('common', 'Tỉnh/thành') ?></label>
            <div class="col-xs-6 col-sm-6 col-full-mobile">
                <?= Html::dropDownList('ProfileForm[province]', $model->province, Constant::province(), ['id' => 'profileform-province', 'class' => 'form-control select2-select']) ?>
                <p class="help-block help-block-error "></p>
            </div>
        </div>

        <?php
        $province = Yii::$app->province;
        $district = [];
        if ($province->getDistricts($model->province)) {
            foreach ($province->getDistricts($model->province) as $value) {
                $district[(string) $value['_id']] = $value['name'];
            }
        }
        ?>


        <?= $form->field($model, 'district')->dropDownList($district, ['prompt' => \Yii::t('common', 'Quận/huyện'), 'class' => 'form-control select2-select'])->label(\Yii::t('common', 'Quận/huyện')) ?>

        <?php
        $ward = [];
        if ($province->getWards($model->district)) {
            foreach ($province->getWards($model->district) as $value) {
                $ward[$value['slug']] = $value['name'];
            }
        }
        ?>


        <?= $form->field($model, 'ward')->dropDownList($ward, ['prompt' => \Yii::t('common', 'Phường/xã'), 'class' => 'form-control select2-select'])->label(\Yii::t('common', 'Phường/xã')) ?>

        <?=
        $form->field($model, 'address', [
            'template' => "{label}<div class='col-xs-6 col-sm-6 col-full-mobile'>{input}{error}</div><div class='col-xs-3 col-sm-3 col-full-mobile'> <div class='col-checkbox'>
        <div class='checkbox'>
        <label for='profileform-display-address'>
            <input type='hidden' name='ProfileForm[display][address]'' value='0'>
            <input " . ($model['display']['address'] == 1 ? 'checked' : '') . " type='checkbox' id='profileform-display-address' name='ProfileForm[display][address]' value='1'>
         <span class='text-success'>".\Yii::t('common', 'Công khai')."</span>
        </label>
        </div>
        </div></div>"
        ])->textInput()->label(\Yii::t('common', 'Địa chỉ'))
        ?>

        <div class="form-group">
            <label class="control-label col-xs-3 col-sm-3 col-full-mobile"><?= \Yii::t('common', 'Xác minh địa chỉ') ?></label>
            <div class="col-xs-6 col-sm-6 col-full-mobile">
                <?php if ($model->active['address'] == 0) { ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label for="upload-image">
                                <input type="file" id="upload-image" multiple onchange="upload(this);">
                            </label>
                        </div>
                        <div class="panel-body">
                            <div class="row form-group">
                                <label class="col-sm-12">
                                    <small><?= \Yii::t('common', 'Để xác minh đại chỉ bằng cách úp ảnh hóa đơn tiền điện, nước, biên lai ngân hàng,....') ?></small>
                                </label>
                                <div class="col-sm-12">
                                    <input type='hidden' id="count_image" value="<?= count($model->image_verification) ?>">
                                    <div id="result" class="row" style="margin-top:20px;">
                                        <?php
                                        if ($model->image_verification) {
                                            foreach ($model->image_verification as $key => $value) {
                                                ?>
                                                <div class="col-sm-6" style="text-align: center;">
                                                    <div class='img_view' style="height: auto">
                                                        <input type="hidden" name="ProfileForm[image_verification][]" value="<?= $value ?>">
                                                        <img  class='img-thumbnail' src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&size=210x190">
                                                    </div>
                                                    <a href='javascript:void(0)' class='btn btn-danger btn-delete btn-sm' style=" margin: 5px 0;" data="<?= $value ?>"><?= \Yii::t('common', 'Xóa') ?></a>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <p class="image_verification_error" style="color: red"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <p style="margin: 7px 0 0 0;" class="text-success"><?= \Yii::t('common', 'Xác thực') ?></p>
                <?php } ?>
            </div>
        </div>
        <?= $form->field($model, 'facebook')->textInput() ?>
        <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
                <?= Html::submitButton(\Yii::t('common', 'Cập nhật'), ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php ob_start(); ?>
<script>
    $("body").on("click", ".btn-delete", function (event) {
        var path = $(this).attr("data");
        var count_image = parseInt($("#count_image").val());
        $("#count_image").val(count_image - 1);
        $(this).parent().remove();
        $.ajax({
            type: "POST",
            url: "<?= Yii::$app->urlManager->createUrl(["ajax/deleteimage"]) ?>",
            data: {path: path}
        });
    });
    $("#upload-image").inputFileText({text: "<?= \Yii::t('common', 'Tải ảnh từ máy tính') ?>", buttonCLass: "btn btn-success"});
    window.upload = function (input) {
        var count_image = parseInt($("#count_image").val()) + input.files.length;
        if ((count_image <= 3) && (input.files.length <= 3) && input.files && input.files[0]) {
            $("#count_image").val(count_image);
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.src = reader.result;
                reader.onload = function (e) {
                    $.ajax({
                        url: "<?= Yii::$app->urlManager->createUrl(["ajax/upload"]) ?>",
                        type: "POST",
                        data: {file: e.target.result},
                        success: function (data) {
                            $("#result").append("<div class=\"col-sm-6\" style=\"text-align: center;\"><div class=\"img_view\" style=\"height: auto\"><input type=\"hidden\" name=\"ProfileForm[image_verification][]\" value=" + data.path + "><img class=\"img-thumbnail\" src=" + data.src + "></div><a href=\'javascript:void(0)\' class=\'btn btn-danger btn-delete  btn-sm\'  style=\"margin: 5px 0;\" data=" + data.path + ">"+'<?= \Yii::t('common', 'Cập nhật') ?>'+"</a></div>");
                        },
                    })
                }
            });
        } else {
            $(".image_verification_error").html("Chỉ upload được tối đa 3 hình ảnh.");
        }
    }
    $('.select2-select').select2({});

    $("#profileform-province").on("change", function (event, state) {
        $.ajax({
            type: "GET",
            url: "/ajax/district/" + $("#profileform-province option:selected").val(),
            success: function (data) {
                var option = '';
                var option_ward = '';

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value=' + data[i]._id + '>' + data[i].name + '</option>';
                    }
                    var district = $('#profileform-district').val();
                    if (data[0].ward.length > 0) {
                        for (var i = 0; i < data[0].ward.length; i++) {
                            option_ward += '<option value=' + data[0].ward[i].slug + '>' + data[0].ward[i].name + '</option>';
                        }
                    }
                } else {
                    option += '<option value>Quận/Huyện</option>';
                    option_ward += '<option value>Phường/Xã</option>';
                }
                $("#profileform-district").html(option);
                $("#profileform-ward").html(option_ward);
            },
        });
    });

    $("#profileform-district").on("change", function (event, state) {
        $.ajax({
            type: "GET",
            url: "/ajax/ward/" + $("#profileform-district option:selected").val(),
            success: function (data) {
                var option = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value=' + data[i].slug + '>' + data[i].name + '</option>';
                    }
                } else {
                    option += '<option>Phường/Xã</option>';
                }
                $("#profileform-ward").html(option);
            },
        });
    });
    window.uploadAvatar = function (input) {
        if (input.files && input.files[0]) {
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.src = reader.result;
                reader.onload = function (e) {
                    $.ajax({
                        url: "<?= Yii::$app->urlManager->createUrl(["ajax/avatar"]) ?>",
                        type: "POST",
                        data: {file: e.target.result},
                        success: function (data) {
                            if (!data.error) {
                                $("#rs-avatar").attr('src', data.src);
                            }
                        },
                    })
                }
            });
        }
    }
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>