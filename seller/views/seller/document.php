<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use common\widgets\Alert;
use common\components\Constant;

$this->title = 'Tài liệu chứng nhận';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Alert::widget() ?>
<div class="row">
    <div class="col-sm-3">
        <?= $this->render('/layouts/sidebar_manager') ?>
    </div>
    <div class="col-sm-9">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= Html::hiddenInput('SellerDocumentForm[id]', \Yii::$app->user->id) ?>
        <h2 style="border-bottom: 2px solid #ccc; margin-top: 30px; margin-bottom: 30px; padding-bottom: 10px">Tài liệu chứng nhận</h2>
        <div class="row form-group">
            <div class="col-sm-12">
                <?= Html::fileInput('SellerDocumentForm[certificate_document][]', '', ['multiple' => true, 'style' => 'display:none', 'id' => 'certificate_document']) ?>
                <div id="result" class="row"/>
                <label for="certificate_document" class="col-sm-3">
                    <img src="<?= Constant::UP_IMAGE ?>" class="img-thumbnail">
                </label>
                <?php
                if ($model->certificate_document) {
                    foreach ($model->certificate_document as $key => $value) {
                        ?>
                        <div class="col-sm-3 img-item">
                            <img src="<?= $value ?>" class="img-thumbnail">
                            <input type="hidden" name="images[]" value="<?= $value ?>" style="width:100%">
                            <a href='javascript:void(0)' class='btn btn-danger'>Xoá</a>

                        </div>
                        <?php
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-6">
            <button  class="btn btn-success">Cập nhật</button>
        </div>												
    </div><!-- preferences-settings -->


    <?php ActiveForm::end(); ?>	
</div><!-- profile-details -->
</div>
<?=
$this->registerJs("
    document.getElementById('certificate_document').addEventListener('change', handleFileSelect, false);

");
?>
