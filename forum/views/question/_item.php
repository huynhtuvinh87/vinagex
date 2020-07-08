<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use common\components\Constant;
?>
<div data-count='<?= $model->vote;?>' id="item-<?php echo $model->id; ?>" class=" item" >
    <div class="list-item">
      
        <div class="row">
           
        <div class="col-md-11">
           <div class="vote pull-left">

              <?php if(Yii::$app->user->isGuest){ ?>
                   <a style="<?= (!empty($model->vote()))?'pointer-events: none; cursor: default;':''; ?>" href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Yii::$app->urlManager->createAbsoluteUrl(['/']) ?>"><span style="<?= (!empty($model->vote()))?'color:#008000':''; ?>" class="glyphicon glyphicon-chevron-up"></span></a>
                  <p id="vote-<?= $model->id; ?>" class="count-vote"><?= $model->vote;?></p>
                   <a style="<?= ($model->vote == 0 ||empty($model->vote()))?'pointer-events: none; cursor: default;':''; ?>"  id="vote-down-<?= $model->id; ?>" href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Yii::$app->urlManager->createAbsoluteUrl(['/']) ?>"><span class="glyphicon glyphicon-chevron-down"></span></a>
              <?php }else{ ?>
                  <a style="<?= (!empty($model->vote()))?'pointer-events: none; cursor: default;':''; ?>" id="vote-up-<?= $model->id; ?>" data-id="<?= $model->id; ?>" class="vote-up" href="javascript:void(0)"><span style="<?= (!empty($model->vote()))?'color:#008000':''; ?>" class="glyphicon glyphicon-chevron-up"></span></a>
                  <p id="vote-<?= $model->id; ?>" class="count-vote"><?= $model->vote;?></p>
                   <a style="<?= ($model->vote == 0 ||empty($model->vote()))?'pointer-events: none; cursor: default;':''; ?>"  id="vote-down-<?= $model->id; ?>" data-id="<?= $model->id; ?>" class="vote-down" href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down"></span></a>
              <?php } ?>

                   
            </div>
        <div class="summary">
            <h4><a href="/question/view/<?= $model->id ?>"><?= $model->title ?></a>
            </h4>
        </div>
        <div class="cp">
            <span class="category"><a href="/search/index?product_type=<?= $model->product_type['slug'];?>"><?= $model->product_type['title'];  ?></a></span>
            <span class="op">Trả lời: <?php echo $model->total_answer; ?> | Thích: <?php echo $model->countLike(); ?> | Đã hỏi <?= Constant::time($model->created_at) ?> bởi <a data-profile="<?= $model->id; ?>" class="name-user" href="<?= Yii::$app->setting->get('siteurl').'/user/view/'.$model->user['id'] ?>"><?= $model->user['fullname'];  ?>
              <div id="profile-<?= $model->id; ?>" class="profile">
                <div class="profile-backgroud">
                    <p class="profile-name"><?= $model->user['fullname'];  ?></p>
                </div>
                <div class="profile-content">
                  <small>
                    Đã hỏi: <?= $model->countQuestion($model->user['id']) ?> <br>
                    Đã trả lời: <?= $model->countAnswerByUser($model->user['id']) ?>
                  </small>
                </div>
              </div>
            </a></span>
            <?php if(\Yii::$app->user->id == $model['user']['id']){ ?>
                <a href="/question/remove/<?= $model->id ?>" class="post-question"><span class="glyphicon glyphicon-trash"></span></a>
                <a href="/question/update/<?= $model->id ?>" class="post-question"><span class="glyphicon glyphicon-pencil"></span></a>
             <?php } ?>
       </div>
            </div>
        </div>
   
 
    </div>
</div>
