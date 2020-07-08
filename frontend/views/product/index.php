<?php

use yii\widgets\ListView;
use common\widgets\Alert;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-title">
    <h1>Sản phẩm</h1>
    <div class="section-title-filter">
        <span>SẮP XẾP: </span>
        <a href="?" class="btn btn-small <?= empty($_GET['field']) ? "btn-success" : "btn-default" ?>">Mặc định</a>

        <a href="?field=order&sort=desc" class="btn btn-small btn-default">Mua nhiều nhất</a>
        <a href="?field=order&sort=desc" class="btn btn-small btn-default">Sắp giao hàng</a>
        <a href="?field=price&sort=asc" class="btn btn-small <?= !empty($_GET['field']) && $_GET['field'] == "price" ? "btn-success" : "btn-default" ?>">Gia tốt nhất <i class="fa fa-arrow-down"></i></a>
        <div class="dropdown">
            <a href="#" class="drop-other btn btn-default">Khác <i class="fa fa-sort-down"></i></a>
            <div class="dropdown-content">
                <a href="?field=insurance_money&sort=desc">Đã đóng bảo hiểm</a>
                <a href="?field=level&sort=desc">Nhà cung cấp tốt nhất</a>
                <a href="?field=review&sort=desc">Đánh giá cao nhất</a>
            </div>
        </div>

    </div>
</div>


<?=
ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'tag' => 'div',
        'class' => 'row list-product',
        'id' => 'list-wrapper',
    ],
    'itemOptions' => ['class' => 'col-xs-6 col-sm-4 col-lg-4'],
    'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
    'itemView' => '_item',
]);
?>
