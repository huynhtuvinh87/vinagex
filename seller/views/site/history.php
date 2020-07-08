<?php

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap\Html;
use common\components\Constant;

?>
<div class="comp-content">
    <?php
    if ($dataProviderHistory->totalCount > 0) {
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
                                                ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30],'contentOptions' => ['style' => 'padding-left: 10px !important'],],
                                                [
                                                    'attribute' => 'Mã đơn hàng',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                                    'value' => function($data ) {
                                                        $html = '<div class="left">';
                                                        $html .= '<strong>Mã đơn hàng: </strong>';
                                                        $html .= '</div>';
                                                        $html .= '<div class="right">';
                                                        $html .= substr($data['invoice_code'], 0,7).'***';
                                                        $html .= '</div>';
                                                        $html .= '<div style="clear: both;"></div>';
                                                        return $html;
                                                    },
                                                ],
                                                [
                                                    'attribute' => 'Thông tin người mua',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                                    'value' => function($data) {
                                                        $html = '<div class="left">';
                                                        $html .= '<strong>Thông tin người mua: </strong>';
                                                        $html .= '</div>';
                                                        $html .= '<div class="right">';
                                                        $html .= '<ul>';
                                                        $html .= '<li>Họ tên: ' . $data['buyer']['name'] . '</li>';
                                                        $html .= '<li>Điện thoại: ' . substr($data['buyer']['phone'], 0, 3) . '********' . '</li>';
                                                        $html .= '<li>Email: ' . substr($data['buyer']['email'], 0, 2)."***".strstr($data['buyer']['email'], '@', false). '</li>';
                                                        $html .= '</ul>';
                                                        $html .= '</div>';
                                                        $html .= '<div style="clear: both;"></div>';


                                                        return $html;
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'Thông tin đơn hàng',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                                    'value' => function($data) {
                                                        $html = '<div class="left">';
                                                        $html .= '<strong>Thông tin đơn hàng: </strong>';
                                                        $html .= '</div>';
                                                        $html .= '<div class="right">';
                                                        $html .= '<ul>';
                                                        $html .= '<li>Danh sách sản phẩm: </li>';
                                                        foreach ($data['product'] as $k => $value) {
                                                            $i = $k + 1;
                                                            $html .= '<li>' . $i . '. <strong>' . $value['title'] . (($value['type'] != 0) ? " Loại " . $value['type'] : "") . '</strong> (' . $value['quantity'] . ' ' . $value['unit'] . ' x ' . Constant::price($value['price']) . ')';
                                                            if ($value['status'] == 0 && $data['status'] == Constant::STATUS_ORDER_PENDING) {
                                                                $html .= '<small class="text-danger"> (Không đủ số lượng để giao)</small>';
                                                            } else if ($value['status'] == 0 && $data['status'] != Constant::STATUS_ORDER_PENDING) {
                                                                $html .= '<small class="text-danger">(Sản phẩm không giao được)</small>';
                                                            }
                                                            $html .= '</li>';
                                                        }

                                                        $html .= '</ul>';
                                                        $html .= '</div>';
                                                        $html .= '<div style="clear: both;"></div>';


                                                        return $html;
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'Tổng tiền',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                                    'value' => function($data ) {
                                                        $total = 0;
                                                        foreach ($data['product'] as $k => $value) {
                                                            $total += $value['quantity'] * $value['price'];
                                                        }
                                                        $html = '<div class="left">';
                                                        $html .= '<strong>Tổng tiền: </strong>';
                                                        $html .= '</div>';
                                                        $html .= '<div class="right">';
                                                        $html .= Constant::price($total);
                                                        $html .= '</div>';
                                                        $html .= '<div style="clear: both;"></div>';
                                                        return $html;
                                                    },
                                                ],
                                                [
                                                    'attribute' => 'Thời gian mua',
                                                    'format' => 'raw',
                                                    'contentOptions' => ['style' => 'padding-left: 10px !important'],
                                                    'value' => function($data ) {
                                                        $html = '<div class="left">';
                                                        $html .= '<strong>Thời gian mua: </strong>';
                                                        $html .= '</div>';
                                                        $html .= '<div class="right">';
                                                        $html .= date('d/m/Y',$data['date_end']);
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
                        }else{
                            echo "<div style='margin-top: 20px'>Chưa có giao dịch nào!</div>";
                        }
                        ?>
                    </div>