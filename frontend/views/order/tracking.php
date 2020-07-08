<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\Constant;
use yii\widgets\Pjax;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container container-mobile">
    <h4 class="main-title"><?= Html::encode($this->title) ?></h4>
    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'id' => 'list-wrapper',
            'class' => 'list-group'
        ],
        'layout' => "{items}\n<div class='pagination-page text-center'>{pager}</div>",
        'itemView' => '_tracking',
    ]);
    ?>
</div>
<?php ob_start(); ?>
<script type="text/javascript">
    // $('body').on('click', '.order-view', function () {
    //     $("#modalHeader span").html($(this).attr("data-title"));
    //     $.ajax({
    //         type: "GET",
    //         url: $(this).attr('href'),
    //         success: function (data) {
    //             $('#modal-order').modal('show').find('#modalContent').html(data)
    //         },
    //     });

    //     return false;
    // });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
