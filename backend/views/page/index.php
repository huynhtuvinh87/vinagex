<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php
            Pjax::begin([
                'id' => 'pjax_gridview_page',
            ])
            ?>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'articleAction',
                        'action' => ['doaction'],
                        'options' => [
                            'class' => 'form-inline'
                        ]
            ]);
            ?>
            <div class="pull-left">
                <div class="form-group" style="margin-bottom: 5px">
                    <select name="action" class="form-control">
                        <option>Hành động</option>
                        <option value="delete">Xoá</option>
                    </select>
                </div>
                <button type="submit" id="doaction" class="btn btn-default">Áp dụng</button>
                <?= Html::a('Thêm mới', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <div style="clear: both;"></div>
            <?php foreach ($model->widget() as $key => $value) { ?>
                  <a class="btn btn-default" href="/page/filter?widget=<?= $key?>"><?= $value ?></a>
            <?php } ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                        [
                        'class' => 'yii\grid\CheckboxColumn',
                        'multiple' => true,
                        'headerOptions' => ['width' => 10]
                    ],
                    [
                        'attribute' => 'title',
                        'label' => 'Tiêu đề',
                    ],
                    [
                        'attribute' => 'slug',
                        'label' => 'Slug',
                    ],
                    [
                        'attribute' => 'image',
                        'label' => 'Hình ảnh',
                        'format' => 'raw',
                        'value' => function($data) {
                            return '<image src='.Yii::$app->setting->get('siteurl_cdn').'/image.php?src='.$data->image.' width="70" />';
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Trạng thái',
                        'format' => 'raw',
                        'value' => function($data) {
                               if($data->status == 0){
                                    return "Hiển thị";
                               }else{
                                    return 'Không hiển thị';
                               }
                            
                        }
                    ],
                    [
                        'attribute' => 'Ngày tạo',
                        'format' => 'raw',
                        'value' => function($data) {
                            return date('d/m/Y', $data->updated_at);
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                        'headerOptions' => ['width' => 50]
                    ],
                ],
            ]);
            ?>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end() ?> 
        </div>
    </div>
</div>
<?= $this->registerJs("
$(document).ready(function() {
    $('form#articleAction button[type=submit]').click(function() {
        return confirm('Rollback deletion of candidate table?');
    });
});
") ?>
