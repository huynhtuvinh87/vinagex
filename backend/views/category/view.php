<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] =['label'=>'Danh muc','url'=>'/category'];
if(!empty($category)){
$this->params['breadcrumbs'][] =['label'=>$category->title,'url'=>'/category/view/'.$category->id];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genres-index">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <?php
            $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
            ?>  
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton(!empty($model->_id)?'Cập nhật':'Thêm mới', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            </div>
            <?php ActiveForm::end(); ?>
            <?php if(Yii::$app->session->getFlash('errors')){ ?>
             <div class="alert alert-danger"><?php echo Yii::$app->session->getFlash('errors'); ?></div>
         <?php } ?>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-12"> 
            <?php
            $form = ActiveForm::begin([
                        'id' => 'categoryAction',
                        'action' => ['doaction'],
                        'options' => [
                            'class' => 'form-inline'
                        ]
            ]);
            ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{pager}",
                'columns' => [
                    [
                        'attribute' => 'Tiêu đề',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = $data['title'];
                            return $html;
                        }
                    ],
                    'slug',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '/category/edit/' . $model['id'].'?parent_id='.$model['parent_id'], [
                                            'title' => 'Sửa',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '/category/remove/' . $model['id'].'?parent_id='.$model['parent_id'], [
                                            'title' => 'Xóa',
                                ]);
                            }

                        ],
                    ],
                ],
            ]);
            ?>
            <?php ActiveForm::end(); ?>

            
        </div>
    </div>
</div>
<?= $this->registerJs("
$(document).ready(function() {
    $('form#categoryAction button[type=submit]').click(function() {
        return confirm('Rollback deletion of candidate table?');
    });
});
") ?>
<?=
$this->registerJs("
$(document).ready(function () {
        $(document).on('change', '.upload-file-selector', function () {
            readURL(this, '.rs-image');
        });
        function readURL(input, id_show) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(id_show).html('<img src=' + e.target.result + '>');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    });
");
?>
