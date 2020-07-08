<?php

use yii\bootstrap\ActiveForm;
?>

<div class="review">

    <?php
    $form = ActiveForm::begin([
                'id' => 'review-form',
                'layout' => 'horizontal',
                'enableAjaxValidation' => true,
                'fieldConfig' => [
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-2',
                        'offset' => 'col-sm-offset-2',
                        'wrapper' => 'col-sm-10',
                    ],
                ],
    ]);
    ?>
    <?= $form->field($model, 'content')->textarea(['style' => 'height:110px'])->label(\Yii::t('common', 'Nội dung')) ?>
    <input type="hidden" id="review-rating" class="form-control" name="Review[star]" value="<?= $model->star ?>">
    <input type="hidden" id="review-product_id" class="form-control" name="Review[product_id]" value="<?= $product->id ?>">
    <div class="form-group">
        <label class="control-label col-sm-2"><?= \Yii::t('common', 'Sao') ?></label>
        <div class='rating-stars col-sm-10'>
            <ul id='stars'>
                <li class='star <?= $model->star >= 1 ? "selected" : "" ?>' title='Rat te' data-value='1'>
                    <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star <?= $model->star >= 2 ? "selected" : "" ?>' title='Khong tot' data-value='2'>
                    <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star <?= $model->star >= 3 ? "selected" : "" ?>' title='Trung binh' data-value='3'>
                    <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star <?= $model->star >= 4 ? "selected" : "" ?>' title='Tot' data-value='4'>
                    <i class='fa fa-star fa-fw'></i>
                </li>
                <li class='star <?= $model->star >= 5 ? "selected" : "" ?>' title='Rat tot' data-value='5'>
                    <i class='fa fa-star fa-fw'></i>
                </li>
            </ul>
        </div>

    </div>

    <div style="overflow: hidden">
        <input type="submit" class="btn btn-success pull-right" value="<?= \Yii::t('common', 'Gửi') ?>">
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php ob_start(); ?>
<script type="text/javascript">
    $('#stars li').on('click', function () {
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');
        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }
        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);

        $('#review-rating').val(ratingValue);
    });
  
        
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>