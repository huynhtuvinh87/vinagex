<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh mục';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genres-index">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <h4>Thêm mới </h4>
            <?php
            $form = ActiveForm::begin(['action' => ['create'], 'options' => ['enctype' => 'multipart/form-data']]);
            ?>  
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <div class="form-group">
                <?= Html::submitButton('Thêm mới', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12"> <?php
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
                'layout' => "{items}\n{summary}\n{pager}",
                'summary'=> "",
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'multiple' => true,
                        'headerOptions' => ['width' => 10]
                    ],
                    [
                        'attribute' => 'title',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = $data->title;
                            if (!empty($data->parent)) {
                                $html .= '<ul>';
                                foreach ($data->parent as $value) {
                                    $html .= '<li>-- ' . $value['title'] . '</li>';
                                }
                                $html .= '</ul>';
                            }
                            return $html;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}{delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', $url, [
                                            'title' => 'Thêm loại sản phẩm',
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
