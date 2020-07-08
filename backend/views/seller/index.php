<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">


            <?php
            Pjax::begin([
                'id' => 'pjax_gridview_news',
            ])
            ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{pager}\n{items}\n{summary}\n{pager}",
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'multiple' => true,
                    ],
                    ['class' => 'yii\grid\SerialColumn'],
                    'fullname',
                    'username',
                    'email',
                    [
                        'attribute' => 'address',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->address;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {delete}',
                        'headerOptions' => ['width' => 50]
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end() ?> 
        </div>
    </div>
</div>

