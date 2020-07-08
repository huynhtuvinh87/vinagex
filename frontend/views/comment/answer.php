<?php

use common\components\Constant;
?>
<?php
if ($model['answers']) {
    for ($i = count($model['answers']) - 1; $i >= 0; $i--) {
        if ($model['answers'][$i]['status'] == 2) {
            ?>
            <div class="qna-item-group"> 
                <span class="answer">A<em class="triangle"></em></span>
                <div class="qna-content"><?= $model['answers'][$i]['content'] ?></div>
                <div class="qna-meta"><a target="_blank" href="/user/view/<?= $model['answers'][$i]['actor_id'] ?>"><?= $model['answers'][$i]['name'] ?></a> - trả lời cách đây <?= Constant::time($model['answers'][$i]['created_at']) ?></div>
                <p><a href="javascript:void(0)" data-id="<?= $model->id ?>" data-name="@<?= $model['answers'][$i]['name'] ?>:" class="comment-reply"><i class="glyphicon glyphicon-share-alt"></i> Trả lời</a></p>
            </div>
            <?php
        }
    }
}
?>