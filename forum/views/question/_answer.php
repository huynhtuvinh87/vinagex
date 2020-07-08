<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\components\Constant;
?>
    
    <div data-count='<?= $model->vote;?>' id="id-<?= $model->id; ?>" class="content-question">
    <div id="rep-<?= $model->id; ?>">


    <div class="vote-answer">
                <?php if(Yii::$app->user->isGuest){ ?>

                   <a style="<?= (!empty($model->vote()))?'pointer-events: none; cursor: default;':''; ?>"  href="<?=  Yii::$app->setting->get('siteurl_id') . '/login?url=' . Yii::$app->urlManager->createAbsoluteUrl(['/question/view/'.$model->question['id']]) ?>"><span style="<?= (!empty($model->vote()))?'color:#008000':''; ?>" class="glyphicon glyphicon-chevron-up"></span></a>
                   <p id="vote-<?= $model->id; ?>" class="count-vote"><?= $model->vote;?></p>
                   <a style="<?= ($model->vote == 0 ||empty($model->vote()))?'pointer-events: none; cursor: default;':''; ?>" href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Yii::$app->urlManager->createAbsoluteUrl(['/question/view/'.$model->question['id']]) ?>"><span class="glyphicon glyphicon-chevron-down"></span></a>

                <?php }else{  ?>

                    <a style="<?= (!empty($model->vote()))?'pointer-events: none; cursor: default;':''; ?>" id="vote-up-<?= $model->id; ?>" data-id="<?= $model->id; ?>" class="vote-up" href="javascript:void(0)"><span style="<?= (!empty($model->vote()))?'color:#008000':''; ?>" class="glyphicon glyphicon-chevron-up"></span></a>
                   <p id="vote-<?= $model->id; ?>" class="count-vote"><?= $model->vote;?></p>
                   <a style="<?= ($model->vote == 0 ||empty($model->vote()))?'pointer-events: none; cursor: default;':''; ?>"  id="vote-down-<?= $model->id; ?>" data-id="<?= $model->id; ?>" class="vote-down" href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down"></span></a>

                <?php } ?>
    </div>

    <div class="question">
            <?= $model->content; ?> 
            <div class="option">
                <?php if(Yii::$app->user->isGuest){ ?>

                    <a href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Yii::$app->urlManager->createAbsoluteUrl(['/question/view/'.$model->question['id']]) ?>"><span class="glyphicon glyphicon-share-alt"></span> Trả lời</a>

                <?php }else{ ?>

                    <a class="reply-answer" data-id="<?= $model->id ?>" href="javascript:void(0)"><span class="glyphicon glyphicon-share-alt"></span> Trả lời</a>

                <?php } ?>
                 
                <?php if (\Yii::$app->user->id == $model['user']['id']) { ?>
                    <a class="remove" href="/question/removeanswer/<?= $model->id; ?>"><span class="glyphicon glyphicon-trash delete"></span></a>
                <?php } ?>
            </div>
        </div>
        <div class="time">
                <span>( <a data-profile="<?= $model->id; ?>" class="name-user" href="<?= Yii::$app->setting->get('siteurl').'/user/view/'.$model->user['id'] ?>"><?= !empty($model->user['fullname'])?$model->user['fullname']:$model->user['username']; ?>
                
                 <div class="profile-<?= $model->id; ?> profile">
                        <div class="profile-backgroud">
                            <p class="profile-name"><?= !empty($model->user['fullname'])?$model->user['fullname']:$model->user['username']; ?></p>
                        </div>
                        <div class="profile-content">
                          <small>
                            Đã hỏi: <?= $model->countQuestion($model->user['id']) ?> <br>
                            Đã trả lời: <?= $model->countAnswerByUser($model->user['id']) ?>
                          </small>
                        </div>
                  </div>    
                </a> đã trả lời <?= Constant::time($model->created_at); ?> )</span>
        </div>
       
        <div id="answer-<?= $model->id; ?>" class="col-md-offset-1">
            <?php if (!empty($model->parent_answer)) { ?>
                <?php foreach ($model->parent_answer as $value) { ?>
                    <!--item -->
                    <div id="parent-<?= $value['id']; ?>" class="sub-reply">
                        <p><?= $value['content']; ?><span> – <small>( <a <?php
                                if (($value['user_id'] == $model->question['user_id'])) {
                                    echo 'class="active"';
                                }
                                ?> href="<?= Yii::$app->setting->get('siteurl').'/user/view/'.$value['user_id'] ?>"><?= !empty($value['fullname'])?$value['fullname']:$value['username']; ?></a> <?= Constant::time($value['created_at']) ?> )</small></span> 
                                <?php if (\Yii::$app->user->id == $value['user_id']) { ?>
                                <a class="remove" href="/question/delanswer/<?php echo $value['id']; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                            <?php } ?>
                        </p>
                    </div>
                    <!--end item -->
                <?php }
            } ?>

        </div>

        <div class="col-md-offset-1 form-reply">

        </div>
    </div>
</div>
