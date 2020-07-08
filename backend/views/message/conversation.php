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
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'Thông tin',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data->owner()['fullname'].' -- '.$data->actor()['fullname'];
                        },
                    ],
                    'message',
                    'date',
                //['class' => 'backend\components\columns\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

