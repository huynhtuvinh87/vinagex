<?php

use yii\widgets\ListView;
use common\widgets\Alert;

$this->params['breadcrumbs'][] = $this->title;
?>


<div class="section-title">
    <h4><?= $this->title ?></h4>

</div>


<?=
ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'tag' => 'div',
        'class' => 'row list-shop list-shop-wish',
        'id' => 'list-wrapper',
    ],
    'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
    'emptyText' => 'Chưa có nhà vườn nào.',
    'itemView' => '_itemSeller',
]);
?>