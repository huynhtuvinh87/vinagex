<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use common\components\Constant;

$this->title = 'Đơn hàng của tôi';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4 style="font-weight: 400; text-transform: uppercase;"><?= Html::encode($this->title) ?></h4>
<?php
Pjax::begin([
    'id' => 'pjax_gridview_history',
])
?>
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
<?php Pjax::end() ?> 
