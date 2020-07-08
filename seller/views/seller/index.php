<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;

$this->title = 'Tổng quan nhà vườn';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="list-info">
    <dl class="dl-horizontal">
        <h4 style="border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px">Thông tin liên hệ </h4>
        <dt>Tên chủ vườn</dt>
        <dd>
            <div class="row">
                <div class="col-sm-10">
                    <?= $model['fullname'] ?>
                </div>
                <div class="col-sm-2">
                    <a href="javascript:void(0)" class="pull-right update" data-field="fullname"><i class="fa fa-edit"></i> Chỉnh sửa</a>
                </div>
            </div>
        </dd>
        <dt>Điện thoại</dt>
        <dd>
            <div class="row">
                <div class="col-sm-9"><?= $model['phone'] ?></div>
                <div class="col-sm-3">
                    <a href="javascript:void(0)" class="pull-right update" data-field="phone" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a> <span class="pull-right" style="color: red"><?= $model['active']['phone'] == 1 ? "<span class='fa fa-check text-success'> Đã xác thực</span>" : "<span class='fa fa-remove text-danger'> Chưa xác thực</span>" ?></span>
                </div>
            </div>
        </dd>

        <dt>Email</dt>
        <dd><div class="row">
                <div class="col-sm-9"><?= $model['email'] ?></div>
                <div class="col-sm-3">
                    <a href="javascript:void(0)" class="pull-right update" data-field="email" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a>
                </div>
            </div></dd>
        <h4 style="border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; margin-top: 30px;">Thông tin nhà vườn</h4>
        <dt>Tên cơ sở</dt>
        <dd>
            <div class="row">
                <div class="col-sm-9"><?= $model['garden_name'] ?> </div>
                <div class="col-sm-3"><a href="javascript:void(0)" class="pull-right update" data-field="garden_name" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a> <span class="pull-right" style="color: red"><?= $model['active']['garden_name'] == 1 ? "<span class='fa fa-check text-success'> Đã xác thực</span>" : "<span class='fa fa-remove text-danger'> Chưa xác thực</span>" ?></span>
                </div>
            </div>
        </dd>
        <dt>Giới thiệu</dt>
        <dd>
            <div class="row">
                <div class="col-sm-9">
                    <div class="seller-about">
                        <?= $model['about'] ?>
                    </div>
                    <div class="row">
                        <?php
                        if (!empty($model['images'])) {
                            foreach ($model['images'] as $key => $value) {
                                ?>
                                <div class="col-sm-3 img-item">
                                    <img class="img-thumbnail" src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $value . '&size=350x300' ?>">

                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-3"><a href="javascript:void(0)" data-modal="modal-lg" class="pull-right update" data-field="about" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a></span>
                </div>
            </div>
        </dd>
        <dt>Địa chỉ</dt>
        <dd>
            <div class="row">
                <div class="col-sm-9"><?= $model['address'] ?>, <?= $model['ward']['name'] ?>, <?= $model['district']['name'] ?> </div>
                <div class="col-sm-3">
                    <a href="javascript:void(0)" class="pull-right update" data-field="address" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a> <span class="pull-right" style="color: red"><?= $model['active']['address'] == 1 ? "<span class='fa fa-check text-success'> Đã xác thực</span>" : "<span class='fa fa-remove text-danger'> Chưa xác thực</span>" ?></span>
                </div>
            </div>
        </dd>
        <dt>Tỉnh thành</dt>
        <dd><?= $model['province']['name'] ?></dd>
        <dt>Thương hiệu</dt>
        <dd>
            <div class="row">
                <div class="col-sm-9">
                    <?= $model['trademark'] ?> 
                </div>
                <div class="col-sm-3">
                    <a href="javascript:void(0)" class="pull-right update" data-field="trademark" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a>
                    <span class="pull-right" style="color: red"><?= $model['active']['trademark'] == 1 ? "<span class='fa fa-check text-success'> Đã xác thực</span>" : "<span class='fa fa-remove text-danger'> Chưa xác thực</span>" ?></span>

                </div>
            </div>
        </dd>
        <dt>Chứng nhận</dt>
        <dd>

            <div class="row">
                <div class="col-sm-9">
                    <?php
                    if (!empty($model['certificate'])) {
                        foreach ($model['certificate'] as $value) {
                            if (!empty($value['image'])) {
                                ?>
                                <div class="img-item" style="float: left; margin-right: 10px">
                                    <img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $value['image'] . '&size=200x280' ?>">
                                    <h4><?= $value['name'] ?></h4>

                                    <p><?= ($value['active'] == 1) ? "<span class='fa fa-check text-success'> Đã xác thực</span>" : "<span class='fa fa-remove text-danger'> Chưa xác thực</span>" ?></p>
                                </div>
                                <?php
                            }
                        }
                    } else {
                        echo "<div class='col-sm-3'><small>( Chưa có chứng nhận nào ! )</small></div>";
                    }
                    ?>
                </div>
                <div class="col-sm-3">
                    <a href="javascript:void(0)" class="pull-right update" data-field="certificate" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a>
                </div>
            </div>
        </dd>
        <dt>Sản phẩm cung cấp</dt>
        <dd>
            <div class="row">
                <div class="col-sm-9">
                    <?php
                    $category = [];
                    if ($model['category']) {
                        foreach ($model['category'] as $key => $value) {
                            $category[] = $value['title'];
                        }
                        echo implode(', ', $category);
                    }
                    ?>
                </div>
                <div class="col-sm-3">
                    <a href="javascript:void(0)" class="pull-right update" data-field="category" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a>
                    <span class="pull-right" style="color: red"><?= $model['active']['category'] == 1 ? "<span class='fa fa-check text-success'> Đã xác thực</span>" : "<span class='fa fa-remove text-danger'> Chưa xác thực</span>" ?></span>

                </div>
            </div>
        </dd>
        <dt>Số lượng cung cấp</dt>
        <dd>
            <div class="row">
                <div class="col-sm-9">
                    <?= $model['output_provided'] ?> <?= $model['output_provided_unit'] ?> 
                </div>
                <div class="col-sm-3">
                    <a href="javascript:void(0)" class="pull-right update" data-field="output_provided" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a><span class="pull-right" style="color: red"><?= $model['active']['output_provided'] == 1 ? "<span class='fa fa-check text-success'> Đã xác thực</span>" : "<span class='fa fa-remove text-danger'> Chưa xác thực</span>" ?></span>
                </div>
            </div>
        </dd>

        <dt>Quy mô nhà vườn</dt>
        <dd>
            <div class="row">
                <div class="col-sm-9">
                    <?= $model['acreage'] ?> <?= $model['acreage_unit'] ?>    
                </div>
                <div class="col-sm-3">
                    <a href="javascript:void(0)" class="pull-right update" data-field="acreage" style="margin-left: 10px;"><i class="fa fa-edit"></i> Chỉnh sửa</a><span class="pull-right" style="color: red"><?= $model['active']['acreage'] == 1 ? "<span class='fa fa-check text-success'> Đã xác thực</span>" : "<span class='fa fa-remove text-danger'> Chưa xác thực</span>" ?></span>
                </div>

            </div>
        </dd>
    </dl>
</div>
<?php
ob_start();
?>
<script type="text/javascript">
    $('body').on('click', '.update', function (event) {
        event.preventDefault();
        var field = $(this).attr("data-field");
        var sizeModal = $(this).attr("data-modal");
        $.ajax({
            type: "POST",
            url: "/seller/update",
            data: {field: field},
            success: function (data) {
                $('#modal-update').find('.modal-dialog').removeClass('modal-lg');
                $('#modal-update').find('.modal-dialog').addClass(sizeModal);
                $('#modal-update').modal('show').find('#modalContent').html(data);
            },
        });
    });

    $('.seller-about').readmore({
        speed: 75,
        collapsedHeight:100,
        lessLink: '<a href="javasrcipt:void(0)" class="text-success">... Rút gọn</a>',
        moreLink: '<a href="javasrcipt:void(0)" class="text-success">... Xem thêm</a>',
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Cập nhật thông tin</span>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Huỷ</button> <button id="btn-update" type="button" class="btn btn-success btn-transport">Đồng ý</button>',
    'id' => 'modal-update',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
<div id='modalContent'>

</div>
<?php
yii\bootstrap\Modal::end();
?>