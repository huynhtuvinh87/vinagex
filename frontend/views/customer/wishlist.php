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
        'id' => 'list-wrapper',
    ],
    'itemOptions' => ['class' => 'col-sm-3 col-lg-3'],
    'emptyText' => \Yii::t('common', 'Không có sản phẩm nào !'),
    'layout' => "<div class='list-product row gird'>{items}</div>\n<div class='pagination-page text-center'>{pager}</div>",
    'itemView' => function($data) {
        return $this->render('/product/_item', ['model' => $data->product]);
    },
]);
?>