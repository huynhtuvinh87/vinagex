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
                    [
                        'attribute' => 'content',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::textarea('content[' . $data->id . ']', strip_tags($data->content), ['class' => 'form-control', 'min' => 1, 'max' => 5,'rows' => '2','cols' => '5']);
                        },
                        'headerOptions' => ['width' => 1000]
                    ],
                    [
                        'attribute' => 'Người trả lời',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->user['fullname'];
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url,$data) {
                                
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>','/forum/delanswer/'.$data->id, [
                                            'title' => Yii::t('app', 'lead-view'),
                                            'class' => 'delete',
                                ]);
                            },
                        ],
                        'headerOptions' => ['width' => 50]
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end() ?> 
        </div>
    </div>
</div>
<?= $this->registerJs("
$(document).ready(function() {
     $('body').on('click', '.delete', function(event) {
        return confirm('Bạn có chắc chắn xóa?');
    });
});
") ?>