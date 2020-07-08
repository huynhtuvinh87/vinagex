<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\ListView;
use yii\grid\GridView;
use common\widgets\Alert;
use yii\bootstrap\Html;
use yii\widgets\Pjax;
use common\components\Constant;

$this->title = $model->garden_name;

$this->params['breadcrumbs'][] = $this->title;
?>
<?= Alert::widget() ?>
<div class="seller-detail">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="seller-detail-title"><?= $this->title ?> <span class="authentic">(<?= $model->active['garden_name'] == 1 ? "Đã xác thực" : "Chưa xác thực" ?>)</span>
                <?= $model->insurance_money ? '<span class="btn btn-success pull-right">Đã đóng bảo hiểm: ' . Constant::price($model->insurance_money) . '</span>' : '' ?>
                <?= $model->level == 0 ? "" : '<span class="btn btn-primary pull-right">' . Constant::USER_LEVEL[$model->level] . '</span>' ?>


            </h2>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <img class="seller-detail-img" src="<?= Yii::$app->setting->image($model->images[0], '400x300') ?>" style="width: 100%">
            <ul class="list-img" style="margin-left:0; margin-top: 20px">
                <?php
                foreach ($model->images as $key => $value) {
                    ?>
                    <li class="<?= $key == 0 ? "active" : "" ?>"><a href="javascript:void(0)"><img src="<?= Yii::$app->setting->image($value, '100x100') ?>" data="<?= Yii::$app->setting->image($value, '400x300') ?>" style="width: 100%"></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="col-sm-8 seller-detail-info">  
            <div class="seller-detail-about">
                <div class="desc max-line"><?= $model->about ?></div>
                <a href="javascript:void(0)" data="seller-about">Chi tiết</a>
            </div>
            <p>Ngày tham gia: <?= date('d/m/Y', $model->created_at) ?></p>
            <p>Thương hiệu: <?= $model->trademark ?> <small><?= $model->active['trademark'] == 1 ? "√ Đã xác thực" : "" ?></small></p>
            <?php
            if ($model->active['certificate'] == 1) {
                ?>
                <p>Chứng nhận: 
                    <?php
                    $cer = [];
                    foreach ($model->certificate as $value) {
                        $cer[] = $value['name'];
                    }
                    echo implode(', ', $cer);
                    ?>
                    <small><?= $model->active['certificate'] == 1 ? "√ Đã xác thực" : "" ?></small>
                </p>
                <?php
            }
            ?>
            <p>Sản phẩm cung cấp: 
                <?php
                $category = [];
                if ($model['category']) {
                    foreach ($model['category'] as $key => $value) {
                        $category[] = '<a href="/filter?seller=' . $model->username . '&type=' . $value['slug'] . '">' . $value['title'] . '</a>';
                    }
                    echo implode(', ', $category);
                }
                ?>
                <small><?= $model['active']['category'] == 1 ? "√ Đã xác thực" : "Chưa xác thực" ?></small>

            </p>
            <p>Quy mô: <?= $model->acreage ?> ha <small><?= $model->active['acreage'] == 1 ? "√ Đã xác thực" : "" ?></small></p>
            <p>Vị trí: <?= $model->address ?>  <small><?= $model->active['address'] == 1 ? "√ Đã xác thực" : "" ?></small></p>
            <p>Sản lượng cung cấp: <?= $model->output_provided ?> tấn/năm <small><?= $model['active']['output_provided'] == 1 ? "√ Đã xác thực" : "" ?></small></p>

            <p class="payment-history">Tổng giao dịch: <a href="javascript:void(0)" data="seller-history">(<?= $countHistory ?> giao dịch)</a></p>
            <div class="rating">
                Đánh giá: <?php
                for ($i = 1; $i < 6; $i++) {
                    if ($i <= round($model->countstar, 0)) {
                        echo '<i class="fa fa-star"></i>';
                    } else {
                        echo '<i class="fa fa-star-o"></i>';
                    }
                };
                ?>
                <span><a href="javascript:void(0)" data="seller-review">(<?= $model->countReview ?> đánh giá)</a></span>
            </div>
            <?php
            if ($static['sum'] > 0) {
                ?>
                <p class="static" style="padding-top:10px">Thống kê: <a href="javascript:void(0)" data="seller-static"> Xem thống kê</a></p>
                <?php
            }
            ?>
        </div>
    </div>
    <div id="seller-about">
        <h4>Giới thiệu</h4>
        <div class="panel panel-default">
            <div class="panel-body">
                <?= $model->about ?>
                <h4>Chứng nhận</h4>
                <div class="row">
                    <?php
                    if (!empty($model['certificate'])) {
                        foreach ($model['certificate'] as $value) {
                            ?>
                            <div class="col-sm-3 img-item">
                                <img src="<?= Yii::$app->setting->image($value['image'], '200x280') ?>">
                                <h4><?= $value['name'] ?></h4>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <div id="seller-product">
        <h4>Sản phẩm</h4>
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'tag' => 'div',
                'id' => 'list-review',
                'class' => 'row'
            ],
            'itemOptions' => ['class' => 'col-xs-6 col-sm-3'],
            'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
            'itemView' => '/product/_item',
        ]);
        ?>
    </div>
    <div id="seller-review">
        <h4>Đánh giá & Nhận xét</h4>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row total-review">
                    <div class="col-sm-3">
                        <div class="total-review-left">
                            <h4>Đánh giá trung bình</h4>
                            <p class="total"><?= round($model->countstar, 1) . '/5' ?></p>
                            <div class="rating">
                                <?php
                                for ($i = 1; $i < 6; $i++) {
                                    if ($i <= round($model->countstar, 0)) {
                                        echo '<i class="fa fa-star"></i>';
                                    } else {
                                        echo '<i class="fa fa-star-o"></i>';
                                    }
                                };
                                ?>
                                <br><span>(<?= $model->countReview ?> đánh giá)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="total-review-right">
                            <ul>
                                <li>
                                    <div class="rating">
                                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($model->medium(5), 1) ?>%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                    <div class="medium">
                                        <span><?= round($model->medium(5), 1) ?>%</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($model->medium(4), 1) ?>%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                    <div class="medium">
                                        <span><?= round($model->medium(4), 1) ?>%</span>
                                    </div>
                                </li>
                                <li><div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($model->medium(3), 1) ?>%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                    <div class="medium">
                                        <span><?= round($model->medium(3), 1) ?>%</span>
                                    </div>
                                </li>
                                <li><div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($model->medium(2), 1) ?>%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                    <div class="medium">
                                        <span><?= round($model->medium(2), 1) ?>%</span>
                                    </div>
                                </li>
                                <li><div class="rating"><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($model->medium(1), 1) ?>%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                    <div class="medium">
                                        <span><?= round($model->medium(1), 1) ?>%</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?=
                ListView::widget([
                    'dataProvider' => $dataProviderReview,
                    'options' => [
                        'tag' => 'div',
                        'id' => 'list-review',
                    ],
                    'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
                    'itemView' => '_review',
                ]);
                ?>
            </div>
        </div>
    </div>
    <?php
    if ($countHistory > 0) {
        ?>
        <div id="seller-history">
            <h4>Lịch sử giao dịch (<?= $countHistory ?>)</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    Pjax::begin([
                        'id' => 'pjax_gridview_history',
                    ])
                    ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProviderHistory,
                        'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                            [
                                'attribute' => 'Người mua',
                                'format' => 'raw',
                                'value' => function($data) {
                                    $html = '<a class="paymentHistory" href="/seller/paymenthistory/'.$data->order['actor'].'" data-title="'.$data->order['name'].'">'.$data->order['name'].'</a>';
                                    return $html;
                                }
                            ],
                            [
                                'attribute' => 'Sản phẩm',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return Html::a($data->product['title'], ['/' . $data->product['slug'] . '-' . $data->product['id']]);
                                }
                            ],
                            [
                                'attribute' => 'Số lượng',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return Constant::price($data->quantity);
                                }
                            ],
                            [
                                'attribute' => 'Thời gian giao dịch',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return $data->date;
                                }
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end() ?> 
                </div>
            </div>
        </div>
        <?php
    }
    if ($static['sum'] > 0) {
        ?>
        <div id="seller-static">
            <h4>Thống kê</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr><th>Sản phẩm</th><th>Số lượng</th><th>Tỉ lệ</th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($static['data'] as $value) {
                                ?>
                                <tr>
                                    <td><?= $value->product_type['title'] ?></td>
                                    <td>
                                        <?php
                                        if ($value->unit = 'Kg' && $value->quantity >= 100) {
                                            echo round($value->quantity / 100, 2) . ' tạ';
                                        }if ($value->unit = 'Kg' && $value->quantity >= 1000) {
                                            echo round($value->quantity / 100, 2) . ' tấn';
                                        } elseif ($value->unit = 'Kg') {
                                            echo $value->quantity . ' kg';
                                        } else {
                                            echo $value->quantity . ' ' . $value->unit;
                                        }
                                        ?>
                                    </td>
                                    <td>

                                        <?= round(($value->quantity / $static['sum']) * 100, 2) ?> %
                                    </td>
                                    <td>
                                        <a href="/seller/static/<?= $value->id ?>" class="staticView" data-title="<?= $value->product_type['title'] ?>">Chi tiết</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<?=
$this->registerJs('
 function goToByScroll(id){
        id = id.replace("link", "");
        $("html,body").animate({
            scrollTop: $("#"+id).offset().top},
            "slow");
    }

    $(".seller-detail-about a, .rating a, .payment-history a, .static a").click(function(e) { 
        e.preventDefault(); 
        goToByScroll($(this).attr("data"));           
    });

');
?>
<?=
$this->registerJs("
    $(document).ready(function () {
        $(document).on('click', '.list-img li a', function () {
            $('.list-img li').removeClass('active');
            var img = $(this).find('img').attr('data');
            $(this).parent().addClass('active');
            $('.seller-detail-img').attr('src', img);     
        });
})
  $('.staticView, .paymentHistory').click(function (){
        $('#modalHeader span').html($(this).attr('data-title'));
        $.get($(this).attr('href'), function(data) {
          $('#modal-seller-detail').modal('show').find('#modalContent').html(data)
       });
       return false;
    });
");
?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Thống kê chi tiết</span>',
    'id' => 'modal-seller-detail',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style=\"text-align:center\"><img src=\"my/path/to/loader.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>