<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($model->answers as $k => $value) {
    ?>
    <div style="margin-bottom: 5px;">

        <p>
            <?= $value['content'] ?> <small>(bởi <?= $value['name'] ?>)</small>
            <?php
            if ($value['status'] < 2) {
                ?>
                <a href="javascript:void(0)" data-id="<?= $model->id ?>" data-key ="<?= $k ?>" class="answer_status" style="color:#5cb85c"><small>Duyệt</small></a>
                <?php
            }
            ?>
            <a href="javascript:void(0)" data-id="<?= $model->id ?>" data-key ="<?= $k ?>" class="answer_delete" style="color:#d9534f"><small><i class="fa fa-trash"></i> Xoá</small></a>
        </p>
        <div class="answer-form" style="overflow: hidden" id="answer-form-<?= $value['id'] ?>">
        </div>
    </div>
    <?php
}
?>
<a href="javascript:void(0)" class="btn btn-primary btn-sm answer_cancel pull-right" style="width: auto">Đóng</a>
<?php ob_start(); ?>
<script type="text/javascript">
    $("body").on("click", ".answer_cancel", function (event, state) {
        $(".list_answer").html("");
    });
    function getFormAnswer(name) {

        var html = '';
        html += '<input type="hidden" name="comment_id" value="<?= $model->id ?>">';
        html += '<textarea name="content" id="comment_content" class="form-control" style="width:100%">' + name + '</textarea><br>';
        html += '<p class="comment_error"></p>';
        html += '<button type="button" id="send" class="btn btn-primary pull-right btn-sm" style="margin-top:5px; width:auto">Gửi</button> <button type="button" class="btn btn-default pull-right cancel_reply btn-sm" style="margin-top:5px; margin-right:5px; width:auto">Huỷ</button>';
        return html;
    }
    $("body").on("click", ".comment-reply", function (event, state) {
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        $(".answer-form").html("");
        $(".form-content").html("");
        $("#answer-form-" + id).html(getFormAnswer(name));
    });
    $("body").on("click", ".cancel_reply", function (event, state) {
        $(".answer-form").html("");
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>