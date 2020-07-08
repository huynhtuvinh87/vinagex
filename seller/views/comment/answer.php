<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
foreach ($model->answers as $k => $value) {
    ?>
    <div><span><?= $value['content'] ?> <small>(bởi <?= $value['name'] ?>)</small></span>
        <a href="javascript:void(0)" data-id="<?= $value['id'] ?>" data-name="@<?= $value['name'] ?>:" class="comment-reply" style="color:#5cb85c"><small><i class="glyphicon glyphicon-share-alt"></i> Trả lời</small></a><?php if ($value['status'] < 2) { ?> | <a href="javascript:void(0)" data-id="<?= $model->id ?>" data-key="<?= $k ?>" class="answer_status" style="color:red"><small> Duyệt</small></a><?php } ?>
        <div class="answer-form" id="answer-form-<?= $value['id'] ?>"></div>
    </div>
    <?php
}
?>
<a href="javascript:void(0)" class="btn btn-primary btn-sm answer_cancel pull-right" style="width: auto">Đóng</a>
