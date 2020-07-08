<?php

use yii\widgets\ListView;
use common\widgets\Alert;

$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="section-title">
        <h1><?= $this->title ?></h1>

    </div>


    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'row',
            'id' => 'list-wrapper',
        ],
        'itemOptions' => ['class' => 'col-xs-6 col-sm-3'],
        'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
        'itemView' => '_item',
    ]);
    ?>