<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = \Yii::t('app', 'Danh sách tin nhắn');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">

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
                        'attribute' => 'owner',
                        'format' => 'raw',
                        'value' => function($data) {

                            return $data->owner['fullname'];
                        },
                    ],
                    [
                        'attribute' => 'actor',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->actor['fullname'];
                        },
                    ],
                    [
                        'attribute' => 'product',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->product['title'];
                        },
                    ],
                    'last_msg_time',
                    'last_msg',
                    [
                        'attribute' => 'Links',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::a('Xem tin nhắn', Yii::$app->homeUrl . 'message/conversation/' . $data->owner['id'] . '?product_id=' . $data->product['id']);
                        },
                    ],
                //['class' => 'backend\components\columns\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

