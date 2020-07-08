<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;
?>
<div id="section-comment" class="sec-pro sec-review">
    <h3 class="sec-title"><?= \Yii::t('common', 'Câu hỏi về sản phẩm này') ?> (<?= $query->count() ?>)</h3>
    <div class="sec-content">
        <div class="comment-success"></div>
        <div class="enter-text">
            <?php $form = ActiveForm::begin(['id' => 'comment-form', 'action' => '/product/comment/' . $product->id, 'options' => ['class' => 'comment-form', 'enctype' => 'multipart/form-data']]); ?>
            <?= $form->field($comment, 'product_id')->hiddenInput(['value' => $product->id])->label(FALSE) ?> 
            <?= $form->field($comment, 'parent')->hiddenInput()->label(FALSE) ?>
            <?= $form->field($comment, 'url')->hiddenInput(['value' => '/' . $product->slug . '-' . $product->id])->label(FALSE) ?>

            <span class="text-input" id="commentform-content">
                <input type="text" id="commentform-content" name="CommentForm[content]" class="form-control" placeholder="<?= \Yii::t('common', 'Viết câu hỏi của bạn ở đây ...') ?>" value="" maxlength="300">                                
            </span>
            <div class="qna-ask-box-tips">
                <div class="send-now">
                    <a class="btn-send" href="javascript:void(0)"><?= \Yii::t('common', 'Gửi') ?></a>
                    <span class="radio-wrap">
                        <input type="radio" id="male" name="CommentForm[sex]" value="1" checked>   
                        <label for="male">    
                            <span class="box"></span> <span class="text"><?= \Yii::t('common', 'Chị') ?></span>
                        </label>
                    </span>
                    <span class="radio-wrap">
                        <input type="radio" id="female" name="CommentForm[sex]" value="0">                                            
                        <label for="female">
                            <span class="box"></span> <span class="text"><?= \Yii::t('common', 'Anh') ?></span>
                        </label>
                    </span>
                    <input <?= (!Yii::$app->user->isGuest && Yii::$app->user->identity->email) ? "readonly" : "" ?> class="info" name="CommentForm[email]" type="email" placeholder="Email không bắt buộc" autocomplete="off" required value="<?= Yii::$app->user->isGuest ? "" : Yii::$app->user->identity->email ?>">
                    <input <?= (!Yii::$app->user->isGuest && (Yii::$app->user->identity->fullname || Yii::$app->user->identity->garden_name == $product->owner['garden_name'])) ? "readonly" : "" ?>  id="commentform-name" class="info" name="CommentForm[name]" type="text" placeholder="Họ tên (bắt buộc)" maxlength="50" autocomplete="off" value="<?= Yii::$app->user->isGuest ? "" : ($product->owner['id'] == Yii::$app->user->id ? Yii::$app->user->identity->garden_name : Yii::$app->user->identity->fullname) ?>">
                    
                </div>
                <div  id="commentform-error" style="color:red; padding-right: 10px"></div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="<?= $query->count() > 0 ? "" : "comment_disable" ?>">
            <div class="midcmt">
                <span class="total-comment"><?= \Yii::t('common', 'Trả lời') ?> (<?= $query->count() > 0 ? $query->sum('count_answer') : 0 ?>)</span>
            </div>
            <?php Pjax::begin(['id' => 'pjax-grid-comment']); ?>    
            <?=
            ListView::widget([
                'dataProvider' => $dataProviderComment,
                'options' => [
                    'tag' => 'ul',
                    'id' => 'list-comment',
                    'class' => 'qna-list'
                ],
                'emptyText' => \Yii::t('common', 'Không có bình luận nào !'),
                'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
                'itemView' => '/comment/_item',
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
<?php ob_start(); ?>
<script type="text/javascript">
    $(".btn-send").on("click", function (event, state) {
  
        $.ajax({
            type: "POST",
            url: "/comment/create",
            data: $('form#comment-form').serialize(),
            success: function (data) {
                if (data != 'error') {
                    $.pjax({container: '#pjax-grid-comment'});
                    $('html, body').animate({
                        scrollTop: $('.comment-success').offset().top
                    }, 1000);
                    var placeholder = '<?= \Yii::t('common', 'Viết câu hỏi của bạn ở đây') ?>';
                    $("#commentform-content").html('<textarea name="CommentForm[content]" required  placeholder="'+placeholder+'"></textarea>');
                    $('#commentform-parent').val("");
                    $('.comment-success').addClass("alert alert-success");

                   
                    $('.comment-success').html("<?= $product->owner['id'] == Yii::$app->user->id?\Yii::t('common', 'Phản hồi thành công'):\Yii::t('common', 'Cảm ơn bạn đã gửi phải hồi về sản phảm này! Phản hồi của bạn sẽ được duyệt trước khi được hiển thị công khai.') ?>");


                    setTimeout(function(){
                        $('.comment-success').remove();
                    },20000);
                } else {
                    $('#commentform-error').html("<?= \Yii::t('common', 'Bạn chưa nhập đầy đủ thông tin.') ?>");
                }

                return false;
            },
        });
    });

    $("#commentform-content input").on("focus", function () {
        $(".enter-text").addClass('unfolded');
        var placeholder = '<?= \Yii::t('common', 'Viết câu hỏi của bạn ở đây') ?>';
        $("#commentform-content").html('<textarea name="CommentForm[content]"  id="commentform-content"  placeholder="'+placeholder+'"></textarea>');
    });
    $(document).on('click', '.comment-reply', function () {
        var name = $(this).attr('data-name');
        var parent = $(this).attr('data-id');
        $('#commentform-parent').val(parent);
        $("#commentform-content").html('<textarea name="CommentForm[content]" required>' + name + '</textarea>');
        $(".enter-text").addClass('unfolded');
        $('html, body').animate({
            scrollTop: $('#comment-form').offset().top
        }, 2000);
    });
    $(document).on('click', '.answer-all', function () {
        var id = $(this).attr('data-id');
        $.ajax({
            type: "GET",
            url: "/comment/answer/" + id,
            success: function (data) {
                $("#q-" + id + " .list-answer").html(data);
            },
        });
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>