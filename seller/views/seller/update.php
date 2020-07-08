<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;
use common\components\Constant;
use dosamigos\ckeditor\CKEditor;

$this->title = 'Cập nhật tài khoản';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Alert::widget() ?>

<?php $form = ActiveForm::begin(['id' => 'profile-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->errorSummary($model, ['header' => 'Vui lòng sửa các lỗi sau:']); ?>
<!-- profile-details -->
<!--<h4 style="border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 30px">Thông tin liên hệ</h4>-->
<?php
if ($field == "fullname") {
    echo $form->field($model, 'fullname', [
        'options' => ['class' => 'form-group row'],
        "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('fullname') . "</label><div class='col-sm-9'>\n{input}\n{hint}\n{error}<input type=hidden name=SellerProfileForm[field] value='fullname'></div>"
    ])->input('text', ['placeholder' => "Nhập tên người liên hệ"]);
}
?>
<?php
if ($field == "phone") {
    echo $form->field($model, 'phone', [
        'options' => ['class' => 'form-group row'],
        "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('phone') . "</label><div class='col-sm-9'>\n{input}\n{hint}\n{error}<input type=hidden name=SellerProfileForm[field] value='phone'></div>"
    ])->input('text', ['placeholder' => "Nhập số điện thoại"]);
}
?>
<?php
if ($field == "email") {
    echo $form->field($model, 'email', [
        'options' => ['class' => 'form-group row'],
        "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('email') . "</label><div class='col-sm-9'>\n{input}\n{hint}\n{error}<input type=hidden name=SellerProfileForm[field] value='email'></div>"
    ])->input('email', ['placeholder' => "Nhập địa chỉ email nếu có"]);
}
?>
<!--<h4 style="border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 30px">Thông tin nhà cung cấp</h4>-->
<?php
if ($field == "garden_name") {
    echo $form->field($model, 'garden_name', [
        'options' => ['class' => 'form-group row'],
        "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('garden_name') . "</label><div class='col-sm-9'>\n{input}\n{hint}\n{error}<input type=hidden name=SellerProfileForm[field] value='garden_name'></div>"
    ])->input('text', ['placeholder' => "Nhập tên cơ sở, công ty"]);
}
if ($field == "about") {
    ?>
    <div class="row">
        <label class="control-label col-sm-12"><?= $model->getAttributeLabel('about') ?></label>
        <div class="col-sm-12">

            <?=
            $form->field($model, 'about')->textarea()->label(FALSE)
            ?>
        </div>
    </div>
    <input type=hidden name=SellerProfileForm[field] value='about'>
    <div class="row form-group">
        <label class="col-sm-12 label-title"><?= $model->getAttributeLabel('images') ?></label>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="overflow: hidden">
                    <label for="upload-image" class=" btn btn-default">
                        <span style="cursor: pointer; color: #80b435; font-size: 12px;"><i class="fa fa-photo"></i> Tải hình ảnh giới thiệu nhà vườn</span>
                        <input type="file" id="upload-image" multiple style="display:none">
                    </label>
                </div>
                <div class="panel-body">
                    <div class="row form-group">
                        <label class="col-sm-12">
                            <small>Hình ành phải chất lượng,tối thiểu 3 hình và tối đa 5 hình</small>
                        </label>
                        <div class="col-sm-12">
                            <ul class="list-unstyled list-images">
                                <?php
                                if (!empty($model->images)) {
                                    foreach ($model->images as $key => $value) {
                                        ?>
                                        <li class="text-center">
                                            <img src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/image.php?src=<?= $value ?>&u=<?= uniqid() ?>" width="150">
                                            <input type="hidden" name="images[]" value="<?= $value ?>">
                                            <p><a href="javascript:void(0)" class="delete">Xoá</a></p>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <?php
}
if ($field == "trademark") {
    echo $form->field($model, 'trademark', [
        'options' => ['class' => 'form-group row'],
        "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('trademark') . "</label><div class='col-sm-9'>\n{input}\n{hint}\n{error}<input type=hidden name=SellerProfileForm[field] value='trademark'></div>"
    ])->input('text', ['placeholder' => "Nhập tên thương hiệu nếu có"]);
}
if ($field == "category") {
    ?>
    <div class="row form-group">
        <label class="col-sm-12 label-title"><?= $model->getAttributeLabel('product_provided') ?></label>
        <div class="col-sm-12">
            <?= Html::dropDownList('SellerProfileForm[category]', $model->category, $model->category(), ['class' => 'form-control select2-tag', 'multiple' => TRUE, 'stype' => 'width:100%']) ?>
            <input type=hidden name=SellerProfileForm[field] value='category'>
        </div>
    </div>
    <?php
}
if ($field == "output_provided") {
    echo $form->field($model, 'output_provided', [
        'options' => ['class' => 'form-group row'],
        "template" => "<label class=\"col-sm-3 col-xs-12 label-title\">" . $model->getAttributeLabel('output_provided') . ' <span>(tấn/năm)</span>' . "</label><div class='col-sm-4 col-xs-8'>{input}\n{hint}\n{error}<input type=hidden name=SellerProfileForm[field] value='output_provided'></div><div class='col-sm-2 col-xs-4'><div class='select'>" . Html::dropDownList('SellerProfileForm[output_provided_unit]', $model->output_provided_unit, $model->output_provided_unit(), ['class' => 'form-control']) . "</div></div>"
    ])->textInput(['type' => 'number']);
}
?>
<?php
if ($field == "acreage") {
    echo $form->field($model, 'acreage', [
        'options' => ['class' => 'form-group row'],
        "template" => "<label class=\"col-sm-3 label-title\">" . $model->getAttributeLabel('acreage') . ' <span>(ha)</span>' . "</label><div class='col-sm-4 col-xs-6'>\n{input}\n{hint}\n{error}<input type=hidden name=SellerProfileForm[field] value='acreage'></div><div class='col-sm-2 col-xs-4'>" . Html::dropDownList('SellerProfileForm[acreage_unit]', $model->acreage_unit, $model->acreage_unit(), ['class' => 'form-control']) . "</div>"
    ])->textInput(['type' => 'number']);
}
if ($field == "address") {
    ?>
    <input type=hidden name=SellerProfileForm[field] value='address'>
    <div class="row form-group">
        <label class="col-sm-12 label-title">Địa chỉ nhà cung cấp</label>
        <div class="col-sm-12">
            <div class="row">
                <label class="col-sm-4 label-title">Tỉnh/thành</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <?= Html::dropDownList('SellerProfileForm[province_id]', $model->province_id, Constant::province(), ['id' => 'sellerprofileform-province_id', 'class' => 'form-control select2-select']) ?>     
                    </div>         
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4 label-title">Quận/huyện</label>
                <div class="col-sm-8">
                    <?php
                    $province = Yii::$app->province;
                    $district = [];
                    if ($province->getDistricts($model->province_id)) {
                        foreach ($province->getDistricts($model->province_id) as $value) {
                            $district[(string) $value['_id']] = $value['name'];
                        }
                    }
                    ?>
                    <?= $form->field($model, 'district')->dropDownList($district, ['class' => 'form-control select2-select', 'prompt' => 'Quận/Huyện'])->label(FALSE) ?>          
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4 label-title">Phường/xã</label>
                <div class="col-sm-8">
                    <?php
                    $ward = [];
                    if ($province->getWards($model->district)) {
                        foreach ($province->getWards($model->district) as $value) {
                            $ward[$value['slug']] = $value['name'];
                        }
                    }
                    ?>
                    <?= $form->field($model, 'ward')->dropDownList($ward, ['class' => 'form-control select2-select', 'prompt' => 'Phường/Xã'])->label(FALSE) ?>           
                </div>
            </div>
            <div class="row">
                <label class="col-sm-4 label-title">Địa chỉ</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'address')->textInput(['placeholder' => 'Tên thôn, xóm, số nhà, tên đường'])->label(FALSE)
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
if ($field == "certificate") {
    ?>
    <input type=hidden name=SellerProfileForm[field] value='certificate'>
    <div class="row form-group">
        <label class="col-sm-12 label-title"><?= $model->getAttributeLabel('certificate') ?></label>
        <div class="col-sm-12">
            <div class="row">
                <?php
                foreach ($model->_certification as $value) {
                    ?>
                    <input type="hidden" name="certificate_active[<?= $value->id ?>]" value="<?= !empty($model->certificate[$value->id]['active']) ? $model->certificate[$value->id]['active'] : 0 ?>">

                    <div class="col-sm-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" <?= !empty($model->certificate[$value->id]) ? "checked" : "" ?> name="SellerProfileForm[certificate][]" class="certificate" value="<?= $value->id ?>">
                                <?= $value->name ?>
                            </label>
                        </div>
                        <div id="image_<?= $value->id ?>" style="display:<?= !empty($model->certificate[$value->id]) ? "block" : "none" ?>">
                            <label for="img_<?= $value->id ?>">
                                <?= Html::fileInput('SellerProfileForm[certificate_img][' . $value->id . ']', '', ['style' => 'display:none', 'id' => 'img_' . $value->id]) ?>
                                <span class="btn btn-primary">Hình ảnh chứng nhận</span>
                            </label>

                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-7 col-img">
                                    <img  style="max-width:150px; margin-bottom:10px" class="img-responsive" src="<?= !empty($model->certificate[$value->id]) ? Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $model->certificate[$value->id]['image'] . '&size=200x280' : Yii::$app->setting->get('siteurl_cdn') . "/image.php?src=images/default.gif&size=200x280" ?>" id="rs-img_<?= $value->id ?>">
                                    <?= !empty($model->certificate[$value->id]['image']) ? "" : "<p class='text-red'>Bạn chưa cập nhật hình ảnh chứng nhận</p>" ?>
                                    <input type="hidden" name="certificate_img[<?= $value->id ?>]" value="<?= !empty($model->certificate[$value->id]['image']) ? $model->certificate[$value->id]['image'] : "" ?>" >
                                    <input type="hidden" name="certificate_active[<?= $value->id ?>]" value="<?= !empty($model->certificate[$value->id]['active']) ? $model->certificate[$value->id]['active'] : 0 ?>" >
                                </div>
                                <div style="margin-bottom: 5px;" class="col-md-3 col-sm-3 col-xs-4">
                                    <?= Html::textInput('certificate_date_begin[' . $value->id . ']', !empty($model->certificate[$value->id]['date_begin']) ? $model->certificate[$value->id]['date_begin'] : '', ['class' => (!empty($model->certificate[$value->id]) && $model->certificate[$value->id]['date_begin'] == "") ? "form-control date_begin required" : "form-control date_begin", 'placeholder' => 'Ngày cấp']) ?>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-4">
                                    <?= Html::textInput('certificate_date_end[' . $value->id . ']', !empty($model->certificate[$value->id]['date_end']) ? $model->certificate[$value->id]['date_end'] : '', ['class' => (!empty($model->certificate[$value->id]) && ($model->certificate[$value->id]['date_end'] == "")) ? "form-control date_end required" : "form-control date_end", 'placeholder' => 'Ngày hết hạn']) ?>
                                </div>
                            </div>

                            <?=
                            $this->registerJs("
                        $(document).ready(function () {
                            $(document).on('change', '#img_" . $value->id . "', function () {
                                    $('#image_" . $value->id . " img').show();
                                    if (this.files && this.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function (e) {
                                            $('#rs-img_" . $value->id . "').attr('src', e.target.result);
                                        }
                                        reader.readAsDataURL(this.files[0]);
                                    }
                            });
                        })
                        ");
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>

    <?php
}
?>

<?php ActiveForm::end(); ?>	

<?php
ob_start();
?>
<script type="text/javascript">
    $(document).ready(function () {
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

    $('.select2-tag').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function (params) {
            return undefined;
        }
    });
    $('.select2-select').select2({});

    $("body").on('change', '#upload-image', function (e) {
        var count = parseInt($(".list-images > li > img").length);
        var max = 5;
        if (this.files) {
            var filesAmount = this.files.length;
            for (i = 0; i < filesAmount; i++) {
                var file = this.files[i];
                if (file.type.indexOf('image') != -1) {
                    if (parseInt(i + count) < max) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var html = '<li class="text-center">';
                            html += '<img src="' + e.target.result + '" width="150" height="150">';
                            html += '<input type="hidden" name="images[]" value="' + e.target.result + '">';
                            html += '<p><a href="javascript:void(0)" class="delete">Xoá</a></p>';
                            html += '</li>';
                            $(".list-images").append(html);
                        }
                        reader.readAsDataURL(this.files[i]);
                    }
                }
            }
        }
    });
    $("body").on('click', '.delete', function (e) {

        $(this).parent().parent().remove();
    });
    $('body').on('click', '#btn-update', function (event) {
<?php
if ($field == "about") {
    ?>
            var count = parseInt($(".list-images > li > img").length);
            if (count < 3) {
                alert("Hình ảnh giới thiệu nhà vườn phải được 3 hình ảnh");
                return false;
            }
    <?php
}
?>
        $("#profile-form").submit();
    });
    $("#sellerprofileform-about").summernote({
        height: 150,
        hint: {
            words: ['apple', 'orange', 'watermelon', 'lemon'],
            match: /\b(\w{1,})$/,
            search: function (keyword, callback) {
                callback($.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                }));
            }
        }
    });
    $('.certificate').change(function () {
        var id = $(this).val();
        $('#image_' + id).fadeToggle();
        $('p.text-red').hide();
        if ($(this).is(':checked')) {
            $(this).attr('checked', true)
        } else {
            $(this).removeAttr('checked');
        }
    });
    $('.date_begin').datepicker({
        dateFormat: 'dd/mm/yy',
        startDate: new Date(),
        autoclose: true,
        todayHighlight: true,
        changeMonth: true,
        changeYear: true
    });
    $('.date_end').datepicker({
        dateFormat: 'dd/mm/yy',
        startDate: new Date(),
        autoclose: true,
        todayHighlight: true,
        changeMonth: true,
        changeYear: true
    });
    $("#sellerprofileform-province_id").on("change", function (event, state) {
        $.ajax({
            type: "GET",
            url: "/ajax/district/" + $("#sellerprofileform-province_id option:selected").val(),
            success: function (data) {
                var option = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value=' + data[i]._id + '>' + data[i].name + '</option>';
                    }
                } else {
                    option += '<option>Quận/Huyện</option>';
                }
                $("#sellerprofileform-district").html(option);
                var option_ward = '';
                if (data.length > 0) {
                    for (var i = 0; i < data[0].ward.length; i++) {
                        option_ward += '<option value=' + data[0].ward[i].slug + '>' + data[0].ward[i].name + '</option>';
                    }
                } else {
                    option_ward += '<option>Phường/Xã</option>';
                }
                $("#sellerprofileform-ward").html(option_ward);
            },
        });
    });
    $("#sellerprofileform-district").on("change", function (event, state) {
        $.ajax({
            type: "GET",
            url: "/ajax/ward/" + $("#sellerprofileform-district option:selected").val(),
            success: function (data) {
                var option = '';
                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        option += '<option value=' + data[i].slug + '>' + data[i].name + '</option>';
                    }
                } else {
                    option += '<option>Phường/Xã</option>';
                }
                $("#sellerprofileform-ward").html(option);
            },
        });
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
<?= $this->registerCss(".select2-container--default{width: 100% !important;}"); ?>