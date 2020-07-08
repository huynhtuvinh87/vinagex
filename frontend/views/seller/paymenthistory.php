<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?=

DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'Tên khách hàng',
            'format' => 'raw',
            'value' => $model->fullname
        ],
        [
            'attribute' => 'address',
            'format' => 'raw',
            'value' => $model->active['address'] == '1' ? "Đã xác thực" : "Chưa xác thực"
        ],
        [
            'attribute' => 'phone',
            'format' => 'raw',
            'value' => $model->active['phone'] == '1' ? "Đã xác thực" : "Chưa xác thực"
        ],
        [
            'attribute' => 'Hình ảnh xác thực',
            'format' => 'raw',
            'value' => $model->active['image_verification'] == '1' ? "Đã xác thực" : "Chưa xác thực"
        ],
    ],
]);
?>