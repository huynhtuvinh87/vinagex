<?php

use yii\grid\GridView;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                    [
                        'attribute' => 'Người báo giá',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data['actor']['fullname'];
                        },
                    ],
                    [
                        'attribute' => 'Cơ sỡ',
                        'format' => 'raw',
                        'value' => function($data) {
                            return '<a href="' . Yii::$app->setting->get('siteurl') . '/nha-cung-cap/' . $data['actor']['username'] . '-' . $data['actor']['id'] . '">' . $data['actor']['garden_name'] . '</a>';
                        },
                    ],
                    [
                        'attribute' => 'Số điện thoại',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data['actor']['phone'];
                        },
                    ],
                    [
                        'attribute' => 'Số tiền báo giá',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Constant::price($data['price']) . ' vnđ';
                        },
                    ],
                    [
                        'attribute' => 'Mô tả',
                        'format' => 'raw',
                        'value' => function($data) {
                            return !empty($data['description']) ? $data['description'] : '(không có)';
                        },
                    ],
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'template' => '{view}{delete}',
//                        'buttons' => [
//                            //view button
//                            'view' => function ($url, $data) {
//                                return Html::a(' <span class="glyphicon glyphicon-eye-open"></span>', '/rfq/view/' . (string) $data['_id']);
//                            },
//                            //view button
//                            'delete' => function ($url, $data) {
//                                return Html::a(' <span class="glyphicon glyphicon-trash"></span>', '/rfq/delete/' . (string) $data['_id'], [
//                                            'title' => 'Xóa',
//                                            'data-confirm' => Yii::t('yii', 'Bạn có muốn xoá không?'),
//                                            'data-method' => 'post',
//                                ]);
//                            },
//                        ],
//                        'headerOptions' => ['width' => 50]
//                    ],
                ],
            ]);
            ?>
        </div>

    </div>
</div>
