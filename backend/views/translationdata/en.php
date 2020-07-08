<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Trang';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div class="col-xs-6">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                    [
                        'attribute' => 'Nội dung',
                        'format' => 'raw',
                        'value' => function($data) {
                            return $data['translation'];
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function($url, $data, $key) {
                                return '<a href="/translationdata/update/'.$key.'?language=en'.(!empty($_GET['page'])?'&page='.$_GET['page']:'').'"><i class="glyphicon glyphicon-pencil"></i></a>';
                            },
                        ],
                        'headerOptions' => ['width' => 50]
                    ],
                ],
            ]);
            ?>
        </div>
        <div class="col-xs-6">
            <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model, 'title')->hiddenInput()->label(false) ?>
                <?php if(!empty($vi)){ ?>
                <div class="form-group">
                    <label>Bản tiếng việt</label>
                <?= Html::textArea('',$vi['translation'],['class'=>'form-control','readonly'=>'']); ?>
                </div>
                <?php } ?>
                <?= $form->field($model, 'content')->textarea()->label('Dịch') ?>
                <?= $form->field($model, 'language')->hiddenInput(['value'=>'en'])->label(false) ?>
                <?= Html::submitButton(empty($model->id)?'Thêm mới':'Cập nhật' , ['class' => empty($model->id)?'btn btn-success pull-right':'btn btn-primary pull-right']); ?>
                <?= !empty($model->id)?'<a href="/translationdata/'.$_GET['language'].(!empty($_GET['page'])?'?page='.$_GET['page']:'').'" style="margin-right: 10px;" class="btn btn-default pull-right">Hủy</a>':'' ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?= $this->registerJs("
$(document).ready(function() {
    $('form#articleAction button[type=submit]').click(function() {
        return confirm('Rollback deletion of candidate table?');
    });
});
") ?>
