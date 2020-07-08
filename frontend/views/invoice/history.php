<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = \Yii::t('common', 'Đơn hàng của tôi');
$this->params['breadcrumbs'][] = $this->title;
?>
<h4 class="detail-order" style="font-weight: 400; text-transform: uppercase;"><?= Html::encode($this->title) ?></h4>

<?=
ListView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'tag' => 'div',
        'id' => 'list-wrapper',
        'class' => 'list-group'
    ],
    'layout' => "{items}\n<div class='pagination-page text-center'>{pager}</div>",
    'itemView' => '_item',
]);
?>