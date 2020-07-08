<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->params['breadcrumbs'][] = ['label' => 'Danh sách', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if ($model->image_verification) {
    $img = '<ul>';
    foreach ($model->image_verification as $key => $value) {
        $img .= "<li style='display:inline-block;' ><a target='_blank' href='".Yii::$app->setting->get('siteurl_cdn').'/'.$value."' class='img-check'><img style='margin-left: 5px' width='200' src='".Yii::$app->setting->get('siteurl_cdn').'/'.$value."'></a><p style='width:200px; margin-top: 10px' class='text-center'><a href='javascript:void(0)' data-key='".$key."' data-id='".$model->id."' class='btn btn-danger delete'>Xóa<a><p></li>";          
    }
    $img .= '</ul>';
}else{
    $img = '(Chưa có hình nào)';
}

?>
<div class="post-index">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-md-8 col-sm-8 col-xs-12">

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'fullname',
                    'username',
                    'email',
                    [
                        'attribute' => 'address',
                        'format' => 'raw',
                        'value' => $model->address.', '.$model->ward['name'].', '.$model->district['name'].', '.$model->province['name']. '<span class="pull-right">' . $form->field($model, "active[address]")->checkbox(['label' => 'Xác thực','class'=>'accuracy-address']) . '</span>'
                    ],
                    [
                        'attribute' => 'Hình xác thực địa chỉ',
                        'format' => 'raw',
                        'value' => $img
                    ],
                    [
                        'attribute' => 'phone',
                        'format' => 'raw',
                        'value' => $model->phone . '<span class="pull-right">' . $form->field($model, "active[phone]")->checkbox(['label' => 'Xác thực','class'=>'accuracy-phone']) . '</span>'
                    ],
                    
                ],
            ]);
            ?>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-success']) ?>

            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php ob_start(); ?>
   <script>
      $(document).on('click', '.delete', function (event) {
        if (confirm('Bạn có muốn xóa hình ảnh?')) {
            var key = parseInt($(this).attr('data-key'));
            var id = $(this).attr('data-id');
            event.preventDefault();
            $.ajax({
                url: '<?= Yii::$app->urlManager->createUrl(["customer/removeimg"]); ?>',
                type: 'post',
                data: 'key='+key+'&id='+id,
                success: function (data) {
                    
                }
            });
        }
    });

   </script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
