<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chứng nhận';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
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
                <?= Html::a('Thêm mới', ['create'], ['id'=>'create-certification','class' => 'btn btn-success','data-title'=>'Thêm mới'])?>
            </div>
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
                        'attribute' => 'name',
                        'label' => 'Tên chứng nhận',
                    ],
                    'slug',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'delete' => function ($url,$model) {

                                return Html::a('<span class="glyphicon glyphicon-trash"></span>',['certification/delete/'.$model['_id']], [
                                            'title' => 'Delete',
                                            'data-method' => 'post',
                                            'data-confirm' => 'Bạn có muốn xóa chứng nhận '.$model['name'].' ?',
                                ]);
                            },
                            'update' => function ($url,$model) {

                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['certification/update/'.$model['_id']], [
                                            'class' => 'update-certification',
                                            'title' => 'Update',
                                            'data-title' => $model['name'],
                                            'data-method' => 'post'
                                ]);
                            }
                        ],
                        'headerOptions' => ['width' => 50]
                    ],
                ],
            ]);
            ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span></span>',
    'id' => 'modal-certification',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style=\"text-align:center\"><img src=\"my/path/to/loader.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>

<?php ob_start(); ?>
   <script>
        $('body').on('click', '#create-certification, .update-certification', function(event) {
            $('#modalHeader span').html($(this).attr('data-title'));
            $.get($(this).attr('href'), function(data) {
              $('#modal-certification').modal('show').find('#modalContent').html(data)
           });
           return false;
        });

        $(document).ready(function() {
            $('form#articleAction button[type=submit]').click(function() {
                return confirm('Rollback deletion of candidate table?');
            });
        });
   </script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

