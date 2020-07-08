<?php

use yii\grid\GridView;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = $this->title;
?>

<?=

GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{pager}",
    'tableOptions' => ['class' => 'table table-bordered table-customize table-responsive'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
        [
            'attribute' => 'Tên sản phẩm',
            'format' => 'raw',
            'value' => function($data ) {

                $html = '<a href="' . \Yii::$app->setting->get('siteurl') . '/' . $data['product']['slug'] . '-' . $data['product']['id'] . '">' . $data['product']['title'] . '</a>';

                return $html;
            },
        ],
        [
            'attribute' => 'Lý do vi phạm',
            'format' => 'raw',
            'value' => function($data) {

                $html = '<ul>';
                foreach ($data['reason'] as $value) {
                    $html .= '<li>' . $value . '</li>';
                }
                $html .= '<li>' . $data['description'] . '</li>';
                $html .= '</ul>';

                return $html;
            }
        ],
        [
            'attribute' => 'Thông tin người báo cáo',
            'format' => 'raw',
            'value' => function($data ) {
                $html = '<ul>';
                $html .= '<li>' . $data['phone'] . '</li>';
                $html .= '<li>' . $data['email'] . '</li>';
                $html .= '</ul>';
                return $html;
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    $view = '';
                    if ($model['status'] == 0) {
                        $view .= Html::a('Chuyển tiếp', ['status', 'id' => (string) $model['_id']], [
                                    'title' => 'Chuyển tiếp',
                        ]);
                    } else {
                        $view .= "Đã chuyển tiếp";
                    }

                    $view .= Html::a(' | Xoá', ['delete', 'id' => (string) $model['_id']], [
                                'title' => 'delete',
                                'data-confirm' => Yii::t('yii', 'Bạn có muốn xoá báo cáo này không?'),
                                'data-method' => 'post',
                    ]);
                    return $view;
                },
            ],
            'headerOptions' => ['width' => 150]
        ],
    ],
]);
?>
