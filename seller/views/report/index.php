<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin-bottom: 10px">
    <a href="/report/index?type=product" class="btn btn-default <?= (!empty($_GET['type']) && $_GET['type'] == 'product')?'active':'' ?>">Sản phẩm</a>
    <a href="/report/index?type=product_image" class="btn btn-default <?= (!empty($_GET['type']) && $_GET['type'] == 'product_image')?'active':'' ?>">Hình ảnh sản phẩm</a>
</div>
<?=

GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{pager}",
    'tableOptions' => ['class' => 'table table-bordered table-customize table-responsive'],
    'emptyText' => 'Chưa có vi phạm nào.',
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
        [
            'attribute' => 'Tên sản phẩm',
            'format' => 'raw',
            'value' => function($data ) {
                $html = '<div class="left">';
                $html .= '<strong>Tên sản phẩm: </strong>';
                $html .= '</div>';
                $html .= '<div class="right">';
                $html .= '<a href="' . \Yii::$app->setting->get('siteurl') . '/' . $data['product']['slug'] . '-' . $data['product']['id'] . '">' . $data['product']['title'] . '</a>';
                $html .= '</div>';
                $html .= '<div style="clear: both;"></div>';
                return $html;
            },
        ],
        [
            'attribute' => 'Thông tin người báo cáo',
            'format' => 'raw',
            'value' => function($data ) {
                $html = '<div class="left">';
                $html .= '<strong>Thông tin người báo cáo: </strong>';
                $html .= '</div>';
                $html .= '<div class="right">';
                $html .= '<ul>';
                $html .= '<li>' . $data['phone'] . '</li>';
                $html .= '<li>' . $data['email'] . '</li>';
                $html .= '</ul>';
                $html .= '</div>';
                $html .= '<div style="clear: both;"></div>';
                return $html;
            },
        ],
        [
            'attribute' => 'Lý do vi phạm',
            'format' => 'raw',
            'value' => function($data) {
                $html = '<div class="left">';
                $html .= '<strong>Lý do vi phạm: </strong>';
                $html .= '</div>';
                $html .= '<div class="right">';
                $html .= '<ul>';
                foreach ($data['reason'] as $value) {
                    $html .= '<li>' . $value . '</li>';
                }
                $html .= '<li>' . $data['description'] . '</li>';
                $html .= '</ul>';
                $html .= '</div>';
                $html .= '<div style="clear: both;"></div>';
                return $html;
            }
        ],
    ],
]);
?>
