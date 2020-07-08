<?php

use common\components\Constant;
use yii\grid\GridView;

$this->title = !empty($user['fullname']) ? $user['fullname'] : $user['username'];
if (!empty($user['email'])) {
    $email = explode('@', $user['email']);
    $count_name = strlen($email[0]) - 3;
    $email = substr($email[0], 0, $count_name) . '***' . '@' . $email[1];
} else {
    $email = \Yii::t('common', 'Không có email');
}
$count_phone = strlen($user['phone']) - 3;
$phone = substr($user['phone'], 0, $count_phone) . '***';
?>
<div class="container container-mobile">
    <div class="wrapper">
        <div class="row">
            <div class="text-center col-lg-2">
                <div class="icon-avata">
                    <?php if (!empty($user['avatar'])) { ?>
                        <img class="avatar" src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=' . $user['avatar'] . '&size=200x200&time=' . time() ?>">
                    <?php } else { ?>
                        <i class='fas fa-user'></i>
                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="profile">
                    <?php if (!empty($user['fullname'])) { ?>
                        <div class="group-profile">
                            <div class="left"><p><?= \Yii::t('common', 'Họ và tên') ?>: <b><?= $user['fullname'] ?></b></p></div>
                        </div>
                    <?php } ?>
                    <div class="group-profile">
                        <div class="left"><p><?= \Yii::t('common', 'Số điện thoại') ?>: <b><?= (Yii::$app->user->id == $user['_id'] || $user['display']['phone'] == 1) ? $user['phone'] : $phone ?></b></p></div>
                        <?php if ($user['active']['phone'] == 1) { ?>
                            <div class="right"><p><span class="pull-right text-success"><i class="fa fa-check"></i> <i class="check">Đã xác minh</i></span></p></div>
                        <?php } ?>
                    </div>
                    <div class="group-profile">
                        <div class="left"><p>Email: <b><?= (Yii::$app->user->id == $user['_id'] || $user['display']['email'] == 1) ? $user['email'] : $email ?></b></p></div>
                    </div>
                    <?php if (!empty($user['address'])) { ?>
                        <div class="group-profile">
                            <div class="left"><p><?= \Yii::t('common', 'Địa chỉ') ?>: <b><?= ((Yii::$app->user->id == $user['_id'] || $user['display']['address'] == 1) ? $user['address'] : '*****') . ', ' . $user['ward']['name'] . ', ' . $user['district']['name'] . ', ' . $user['province']['name'] ?></b></p></div>
                            <?php if ($user['active']['address'] == 1) { ?>
                                <div class="right"><p><span class="pull-right text-success"><i class="fa fa-check"></i> <i class="check">Đã xác minh</i></span></p></div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="group-profile">
                        <div class="left"><p><?= \Yii::t('common', 'Ngày tham gia') ?>: <b><?= date('d/m/Y', $user['created_at']) ?></b></p></div>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="col-lg-5">
                <div class="history">
                    <h4><b><?= \Yii::t('common', 'Lịch sử giao dịch') ?></b></h4>
                    <div class="list-history">
                        <p>- <?= \Yii::t('common', 'Số lần giao dịch thành công') ?>: <b><?= $user->countDealBuyer() ?></b></p>
                        <p>- <?= \Yii::t('common', 'Số lượng nhà cung cấp khác nhau') ?>: <b><?= $user->count_seller_order_success() ?></b></p>
                        <p>- <?= \Yii::t('common', 'Đánh giá của các nhà cung cấp') ?>: <span class="review-buyer">
                                <?php
                                foreach (Constant::REVIEW_BUYER as $key => $value) {
                                    $review[] = '<b>' . $value . ' (' . $user->count_review_buyer($key) . ')' . '</b>';
                                }
                                echo implode(", ", $review);
                                ?>
                            </span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2><?= \Yii::t('common', 'Giao dịch gần đây') ?></h2>
                <p><?= \Yii::t('common', 'Danh sách đơn hàng giao dịch thành công') ?></p>            
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => ['class' => 'table table-bordered table-customize table-striped table-responsive'],
                    'emptyText' => \Yii::t('common', 'Chưa có đơn hàng nào'),
                    'columns' => [
                        [
                            'attribute' => \Yii::t('common', 'Đơn hàng'),
                            'format' => 'raw',
                            'value' => function($data ) {
                                $html = '<div class="left">';
                                $html .= '<strong>' . \Yii::t('common', 'Đơn hàng') . ': </strong>';
                                $html .= '</div>';
                                $html .= '<div class="right">';
                                $html .= (Yii::$app->user->id == $data['buyer']['id']) ? $data['code'] : substr($data['code'], 0, 6) . '***';
                                $html .= '</div>';
                                $html .= '<div style="clear: both;"></div>';
                                return $html;
                            },
                        ],
                        [
                            'attribute' => \Yii::t('common', 'Nhà cung cấp'),
                            'format' => 'raw',
                            'headerOptions' => ['width' => 400],
                            'value' => function($data) {
                                $html = '<div class="left">';
                                $html .= '<strong>' . \Yii::t('common', 'Nhà cung cấp') . ': </strong>';
                                $html .= '</div>';
                                $html .= '<div class="right">';
                                $html .= '<ul>';
                                $html .= '<li><b><a target="_blank" href="' . Yii::$app->setting->get('siteurl') . '/nha-vuon/' . $data['owner']['id'] . '">' . $data['owner']['garden_name'] . '</a></b></li>';
                                $html .= '<li><i class="fas fa-map-marker-alt"></i> ' . $data['owner']['address'] . ',' . $data['owner']['ward']['name'] . ',' . $data['owner']['district']['name'] . ',' . $data['owner']['province']['name'] . '</li>';
                                $html .= '</ul>';
                                $html .= '</div>';
                                $html .= '<div style="clear: both;"></div>';


                                return $html;
                            }
                        ],
                        [
                            'attribute' => \Yii::t('common', 'Sản phẩm'),
                            'format' => 'raw',
                            'value' => function($data) {
                                $html = '<div class="left">';
                                $html .= '<strong>' . \Yii::t('common', 'Sản phẩm') . ': </strong>';
                                $html .= '</div>';
                                $html .= '<div class="right">';
                                $html .= '<ul>';
                                foreach ($data['product'] as $k => $value) {
                                    $i = $k + 1;
                                    $html .= '<li>' . $i . '. <a target="_blank" href="' . Yii::$app->setting->get('siteurl') . '/' . $value['slug'] . '-' . $value['id'] . '"><strong>' . $value['title'] . (($value['type'] != 0) ? " Loại " . $value['type'] : "") . '</strong></a> (' . $value['quantity'] . ' ' . $value['unit'] . ' x ' . Constant::price($value['price']) . ')';
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
                            'value' => function($data ) {
                                $html = '<div class="left">';
                                $html .= '<strong>' . \Yii::t('common', 'Ngày mua') . ': </strong>';
                                $html .= '</div>';
                                $html .= '<div class="right">';
                                $html .= date('d/m/Y', $data['created_at']);
                                $html .= '</div>';
                                $html .= '<div style="clear: both;"></div>';
                                return $html;
                            },
                            'headerOptions' => ['width' => 130]
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2><?= \Yii::t('common', 'Đánh giá của các nhà cung cấp') ?></h2>
                <div class="list-review">
                    <?php if (!empty($review_buyer)) { ?>
                        <?php foreach ($review_buyer as $key => $value) { ?>
                            <div class="item-review">
                                <i><?= !empty($value['description']) ? '"' . $value['description'] . '"' : "" ?></i> <small>(<?= Constant::REVIEW_BUYER[$value['level_satisfaction']] ?>)</small> - <b><a target='_blank' href='/nha-vuon/<?= $value['owner']['id'] ?>'><?= $value['owner']['garden_name'] ?></a></b>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <?= \Yii::t('common', 'Chưa có đánh giá nào !') ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>