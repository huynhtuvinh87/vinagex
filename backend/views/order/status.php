<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use common\components\Constant;
use yii\bootstrap\ActiveForm;
?>


<?php $form = ActiveForm::begin(['id' => 'orderStatus']); ?>
<?php
foreach ($model as $value) {
    ?>
    <div class="row">

        <div class="col-sm-3">
            <p><?= $value['title'] ?></p>
            <p><?= $value['quantity'] ?> x <?= $value['price'] ?></p>
        </div>
        <div class="col-sm-3">
            <p>Tổng tiền:</p>
            <p><strong><?= Constant::price($value['quantity'] * $value['price']) ?></strong></p>
        </div>
        <div class="col-sm-3">
            <p>Ngày giao:</p>
            <p><strong><?= \Yii::$app->formatter->asDatetime($value['delivery_date'], "php:d/m/Y") . ' ' . $value['time'] ?></strong></p>
        </div>
        <div class="col-sm-3">
            <?php
            if ($value['status'] <= 2) {
                ?>
                <a href="javascript:void(0)" data-id="<?= (string) $value['_id'] ?>" class="btn btn-success btn-status">Hoàn thành</a>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}
?>
<?php ActiveForm::end(); ?>
