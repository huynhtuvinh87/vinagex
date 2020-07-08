<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap\Html;
use common\components\Constant;

$this->title = \Yii::t('common', 'Lịch sử giao dịch');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container container-mobile">
    <?= $this->render('menuMobile', ['model' => $model]) ?>
    <div id="main-content" class="company-content">
        <div id="content" class="grid-main">
            <div class="main-wrap">
                <div class="top-company">
                    <h3 class="title" title="<?= $model->garden_name ?>">
                        <?= $this->title ?> (<?= $countHistory ?>)

                    </h3>

                    <div class="option">
                        <!--<a href="#" class="chat-now">!</a>-->
                        <?= $model->active['insurance_money'] == 1 ? "<a href='#' class='ubmit-order'>" . \Yii::t('common', 'Đã đóng bảo hiểm: ') . number_format($model->insurance_money) . " ₫</a>" : "" ?>
                    </div>

                </div>
                <div class="company-section">
                    <div class="comp-content">
                        <?php
                        if ($countHistory > 0) {
                            ?>
                            <div id="seller-history">
                                <?php
                                Pjax::begin([
                                    'id' => 'pjax_gridview_history',
                                ])
                                ?>
                                <?=
                                GridView::widget([
                                    'dataProvider' => $dataProviderHistory,
                                    'layout' => "{items}\n{pager}",
                                    'tableOptions' => ['class' => 'table table-bordered table-customize table-responsive'],
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30], 'contentOptions' => ['style' => 'padding-left: 10px !important'],],
                                        [
                                            'attribute' => \Yii::t('common', 'Mã đơn hàng'),
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                            'value' => function($data ) {
                                                $html = '<div class="left">';
                                                $html .= '<strong>' . \Yii::t('common', 'Mã đơn hàng') . ': </strong>';
                                                $html .= '</div>';
                                                $html .= '<div class="right">';
                                                $html .= substr($data['invoice_code'], 0, 7) . '***';
                                                $html .= '</div>';
                                                $html .= '<div style="clear: both;"></div>';
                                                return $html;
                                            },
                                        ],
                                        [
                                            'attribute' => \Yii::t('common', 'Thông tin người mua'),
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                            'value' => function($data) {
                                                $html = '<div class="left">';
                                                $html .= '<strong>' . \Yii::t('common', 'Thông tin người mua') . ': </strong>';
                                                $html .= '</div>';
                                                $html .= '<div class="right">';
                                                $html .= '<ul>';
                                                $html .= '<li>' . \Yii::t('common', 'Họ và tên') . ': ' . $data['buyer']['name'] . '</li>';
                                                $html .= '<li>' . \Yii::t('common', 'Số điện thoại') . ': ' . substr($data['buyer']['phone'], 0, 3) . '********' . '</li>';
                                                $html .= '<li>Email: ' . substr($data['buyer']['email'], 0, 2) . "***" . strstr($data['buyer']['email'], '@', false) . '</li>';
                                                $html .= '</ul>';
                                                $html .= '</div>';
                                                $html .= '<div style="clear: both;"></div>';


                                                return $html;
                                            }
                                        ],
                                        [
                                            'attribute' => \Yii::t('common', 'Thông tin đơn hàng'),
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                            'value' => function($data) {
                                                $html = '<div class="left">';
                                                $html .= '<strong>' . \Yii::t('common', 'Thông tin đơn hàng') . ': </strong>';
                                                $html .= '</div>';
                                                $html .= '<div class="right">';
                                                $html .= '<ul>';
                                                $html .= '<li>' . \Yii::t('common', 'Danh sách sản phẩm') . ': </li>';
                                                foreach ($data['product'] as $k => $value) {
                                                    $i = $k + 1;
                                                    $html .= '<li>' . $i . '. <strong>' . Yii::t('data', 'product_title_' . $value['id']) . (($value['type'] != 0) ? "  " . Yii::t('common', 'Loại') . " " . $value['type'] : "") . '</strong> (' . $value['quantity'] . ' ' . Yii::t('common', $value['unit']) . ' x ' . Constant::price($value['price']) . ')';
                                                    $html .= '</li>';
                                                }

                                                $html .= '</ul>';
                                                $html .= '</div>';
                                                $html .= '<div style="clear: both;"></div>';


                                                return $html;
                                            }
                                        ],
                                        [
                                            'attribute' => \Yii::t('common', 'Tổng tiền'),
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                            'value' => function($data ) {
                                                $total = 0;
                                                foreach ($data['product'] as $k => $value) {
                                                    $total += $value['quantity'] * $value['price'];
                                                }
                                                $html = '<div class="left">';
                                                $html .= '<strong>' . \Yii::t('common', 'Tổng tiền') . ': </strong>';
                                                $html .= '</div>';
                                                $html .= '<div class="right">';
                                                $html .= Constant::price($total);
                                                $html .= '</div>';
                                                $html .= '<div style="clear: both;"></div>';
                                                return $html;
                                            },
                                        ],
                                        [
                                            'attribute' => \Yii::t('common', 'Ngày mua'),
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                            'value' => function($data ) {
                                                $html = '<div class="left">';
                                                $html .= '<strong>' . \Yii::t('common', 'Ngày mua') . ': </strong>';
                                                $html .= '</div>';
                                                $html .= '<div class="right">';
                                                $html .= date('d/m/Y', $data['date_end']);
                                                $html .= '</div>';
                                                $html .= '<div style="clear: both;"></div>';
                                                return $html;
                                            },
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php Pjax::end() ?> 
                            </div>


                            <?php
                        }
                        if (!empty($static['num']) && $static['sum'] > 0) {
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
                </div>
            </div>
        </div>
        <?= $this->render('sidebar', ['model' => $model]) ?>
    </div>
</div>
<?=
$this->registerJs("
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