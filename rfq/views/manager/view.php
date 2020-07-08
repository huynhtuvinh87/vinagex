<?php
/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
use common\components\Constant;
use yii\helpers\Url;

$this->title = $model->title;
?>

<?= forum\widgets\FilterWidget::widget() ?>


<div class="container">
    <div class="header-question">
        <div class="title-question"><h3><?= $model->title; ?></h3></div>
    </div>

    <div class="row">

        <div class="col-md-8">

            <div id='rep-<?= $model->_id; ?>' class="bordernone content-question">
                <div class="question" id="question">
                    <?= $model->content; ?>
                    <div class="option">

                        <?php if (Yii::$app->user->isGuest) { ?>

                            <a href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Yii::$app->urlManager->createAbsoluteUrl(['/question/view/' . $model->id]) ?>"><span class="glyphicon glyphicon-share-alt"></span> Trả lời</a>

                            <a href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Yii::$app->urlManager->createAbsoluteUrl(['/question/view/' . $model->id]) ?>"><span style="margin-left: 30px;<?= ($model->like($model->id, \Yii::$app->user->id) == 1) ? 'color: #29a329;' : ''; ?>" class="glyphicon glyphicon-thumbs-up"></span> <span style="<?= ($model->like($model->id, \Yii::$app->user->id) == 1) ? 'color: #29a329;' : ''; ?>" class="count-like"><?php echo $model->countLike(); ?></span></a>

                        <?php } else { ?>

                            <a class="reply-question" href="javascript:void(0)" data-id="<?= $model->id ?>"><span class="glyphicon glyphicon-share-alt"></span> Trả lời</a>

                            <a id="like-<?= $model->id; ?>" class="like" data-id_like="<?= $model->id; ?>" href="javascript:void(0)"><span style="margin-left: 30px;<?= ($model->like($model->id, \Yii::$app->user->id) == 1) ? 'color: #29a329;' : ''; ?>" class="glyphicon glyphicon-thumbs-up"></span> <span style="<?= ($model->like($model->id, \Yii::$app->user->id) == 1) ? 'color: #29a329;' : ''; ?>" class="count-like"><?php echo $model->countLike(); ?></span></a>

                        <?php } ?>

                        <?php if (\Yii::$app->user->id == $model['user']['id']) { ?>
                            <a class="remove" href="/question/delete/<?= $model->id; ?>"><span class="glyphicon glyphicon-trash delete"></span></a>
                            <a href="/question/update/<?= $model->id ?>" class="post-question"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?php } ?>

                    </div>
                </div>
                <div class="time">
                    <span >( <a data-profile="<?= $model->id; ?>" class="name-user" href="<?= !empty($model->user['username'])?Yii::$app->setting->get('siteurl').'/nha-vuon/'.$model->user['username']:'' ?>"><?= $model->user['fullname'] ?>
                            <div class="profile-<?= $model->id; ?> profile">
                                <div class="profile-backgroud">
                                    <p class="profile-name"><?= $model->user['fullname']; ?></p>
                                </div>
                                <div class="profile-content">
                                    <small>
                                        Đã hỏi: <?= $model->countQuestion($model->user['id']) ?> <br>
                                        Đã trả lời: <?= $model->countAnswerByUser($model->user['id']) ?>
                                    </small>
                                </div>
                            </div>
                        </a> đã hỏi <?= Constant::time($model->created_at) ?> )</span>
                </div>
                <div  class="form-question-reply">
                    <div class="form-group">
                        <label class="comment">Trả lời:</label>
                        <?php $form = ActiveForm::begin(['options' => ['class' => 'reply-question-form']]); ?>
                        <input type="hidden" name="question_id" id="question_id">
                        <?= $form->field($answer, 'content')->textarea(['id' => 'question-form', 'row' => 5])->label(FALSE); ?>
                        <?= Html::submitButton('Trả lời', ['class' => 'btn btn-success pull-right button-reply']); ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

            <?php if ($countAnswer > 0) { ?>

                <div class="bordernone content-question">
                    <h3 class="count-answer" data-count="<?= $countAnswer; ?>"><span><?= $countAnswer; ?></span> trả lời</h3>
                </div>
                <?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => [
                        'tag' => 'div',
                        'id' => 'wraper',
                    ],
                    'layout' => "{items}\n<div class='row'><div class='col-sm-12 pagination-page'>{pager}</div></div>",
                    'itemView' => '/question/_answer',
                ]);
                ?>

            <?php } else { ?>

                <div class="bordernone content-question">
                    <h5 class="empty">Chưa có câu trả lời nào</h5>
                </div>
                <div id="wraper">
                </div>
            <?php } ?>
        </div>

        <div class="col-md-3 col-md-offset-1 menu-right">
            <?php if (!empty($involveQuestion)) { ?>
                <div class="right">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4>Các câu hỏi liên quan</h4></div>
                        <div class="panel-body">

                            <?php foreach ($involveQuestion as $value) { ?>
                                <!--item -->
                                <div class="news-questions">
                                    <a href="/question/view/<?= $value->id ?>"><?= $value->title ?></a>
                                    <p><small>Trả lời: <?= $value->total_answer; ?> | Đã hỏi bởi <a data-profile="<?= $value->id; ?>" class="name-user" href="<?= Yii::$app->setting->get('siteurl').'/user/view/'.$value->user['id'] ?>"><?= !empty($value->user['fullname'])?$value->user['fullname']:$value->user['username']; ?></a></small></p>
                                </div>
                                <!-- end item -->
                            <?php } ?>

                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="right">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Các câu hỏi mới</h4></div>
                    <div class="panel-body">

                        <?php foreach ($model->newQuestion() as $value) { ?>
                            <!--item -->
                            <div class="news-questions">
                                <a href="/question/view/<?= $value->id ?>"><?= $value->title ?></a>
                                <p><small>Trả lời: <?= $value->total_answer; ?> | Đã hỏi bởi <a data-profile="<?= $value->id; ?>" class="name" href="<?= Yii::$app->setting->get('siteurl').'/user/view/'.$value->user['id'] ?>"><?= !empty($value->user['fullname'])?$value->user['fullname']:$value->user['username']; ?></a></small></p>
                            </div>
                            <!-- end item -->
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="form">
    <div class="form-group">
        <label class="comment">Trả lời:</label>
        <?php $form = ActiveForm::begin(['options' => ['id' => 'reply-answer-form']]); ?>
        <input type="hidden" name="answer_id" class="answer_id" >
        <?= $form->field($answer, 'content_answer')->textarea(['id' => 'answer-form', 'row' => 5])->label(FALSE); ?>
        <?= Html::submitButton('Trả lời', ['class' => 'btn btn-success pull-right']); ?>
        <?php ActiveForm::end(); ?>
    </div>

</div>

<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Chú ý!</span>',
    'id' => 'modal-delete',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style=\"text-align:center\"><img src=\"my/path/to/loader.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>

<?php ob_start(); ?>
<script>
    $('.name-user').bind('mouseenter', function () {
        var id = $(this).attr('data-profile');
        $('.profile-' + id).show();
    });
    $('.name-user').bind('mouseleave', function () {
        var id = $(this).attr('data-profile');
        $('.profile-' + id).hide();
    });

    function getAnswer(data) {
        if (data.user_id == '<?= $model->user['id'] ?>') {
            var active = 'active';
        }
        var html = '<div id="parent-' + data.id + '" class="sub-reply">';
        html += '<p>' + data.content + '<span> --<small> ( <a class="' + active + '" href="">' + data.fullname + '</a> ' + '0 giây )' + '</small></span><a class="remove" href="/question/delanswer/' + data.id + '"><span class="glyphicon glyphicon-remove"></span></a></p>';
        html += '</div>';
        return html;
    }

    $(document).ready(function () {
        $("body").on("click", ".remove", function (event) {
            $.get($(this).attr('href'), function (data) {
                $('#modal-delete').modal('show').find('#modalContent').html(data)
            });
            return false;
        });
    });

    $(document).ready(function () {
        $('.reply-question').click(function () {
            var id = $(this).attr('data-id');
            $('#question_id').val(id);
            $('#rep-' + id + ' .form-question-reply').toggle();
        });


        $("body").on("click", ".reply-answer", function (event) {
            $(".form-reply").html('');
            var id = $(this).attr('data-id');
            $('#rep-' + id + ' .form-reply').html($("#form").html());
            $('.answer_id').val(id);
            $('#rep-' + id + ' .form-reply').show();

        });
    });


    $(document).on('submit', '.reply-question-form', function (event) {
        var count = parseInt($('.count-answer').attr('data-count'));
        
        event.preventDefault();
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/answer"]); ?>',
            type: 'post',
            data: $('form.reply-question-form').serialize(),
            success: function (data) {
                if (isNaN(count)) {
                    count = 1
                }else{
                    count = count + 1;  
                }
                $('.form-question-reply').hide();
                $('#question-form').val('');
                $('#wraper').prepend(data);
                $('.empty').html('<h3 class="count-answer" data-count="'+count+'"><span>'+count+'</span> trả lời</h3>');
            }
        });
    });

    $(document).on('submit', '#reply-answer-form', function (event) {
        event.preventDefault();
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/answer"]); ?>',
            type: 'post',
            data: $(this).serialize(),
            success: function (data) {
                getAnswer(data.data);
                $('.form-reply').hide();
                $('#answer-form').val('');
                $('#answer-' + data.id).append(getAnswer(data.data));
            }
        });
    });

    function addLike() {
        var id = $(this).attr('data-id_like');
        var like = parseInt($(this).find('.count-like').html());
        like = like + 1;
        $(this).find('.count-like').html(like);
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/like"]); ?>',
            type: 'POST',
            data: 'idAdd=' + id,
            success: function (data) {
                $('#like-' + id).find('span').css('color', '#29a329');
                $('#like-' + id).css('text-decoration', 'none');
            }
        });
        $(this).one("click", removeLike);
    }

    function removeLike() {
        var id = $(this).attr('data-id_like');
        var like = parseInt($(this).find('.count-like').html());
        like = like - 1;
        $(this).find('.count-like').html(like);
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/like"]); ?>',
            type: 'POST',
            data: 'idRemove=' + id,
            success: function (data) {
                $('#like-' + id).find('span').css('color', '#808080');
                $('#like-' + id).css('text-decoration', 'none');
            }
        });
        $(this).one("click", addLike);
    }
<?php if ($model->like($model->id, \Yii::$app->user->id) == 1) { ?>
        $(".like").one("click", removeLike);
<?php } else { ?>
        $(".like").one("click", addLike);
<?php } ?>

    $("body").on("click", ".vote-up", function (event) {
        var id = $(this).attr('data-id');
        var countVote = parseInt($('#vote-' + id).html());
        countVote = countVote + 1;
        $('#vote-' + id).html(countVote);
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/voteanswer"]); ?>',
            type: 'post',
            data: 'idVote=' + id + '&idCheck=' + id,
            success: function (data) {
                $('#id-' + id).remove();

                $('.content-question[data-count]').each(function (value) {
                    $('#id-' + id).remove();
                    $this = $(this);
                    list_count = parseInt($this.attr('data-count'));
                    list_id = $this.attr('id');
                    if (!(countVote > list_count)) {
                        $('#' + list_id + '').after(data);
                    } else {
                        if (countVote == list_count) {
                            return false;
                        } else {
                            $('#' + list_id + '').before(data);
                            $('html, body').animate({
                                scrollTop: $('#id-' + id).offset().top
                            }, 2000);
                            return false;
                        }
                    }
                });
                if (!($("#wraper").find('#id-' + id).length)) {
                    $('#wraper').append(data);
                }
            }
        });
        $('#vote-up-' + id).css({'pointer-events': 'none', 'cursor': 'default'});
        $('#vote-down-' + id).css({'pointer-events': 'auto', 'cursor': 'pointer'});
    });

    $("body").on("click", ".vote-down", function (event) {
        var id = $(this).attr('data-id');
        var countVote = parseInt($('#vote-' + id).html());
        countVote = countVote - 1;
        $('#vote-' + id).html(countVote);

        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/voteanswer"]); ?>',
            type: 'post',
            data: 'idUnvote=' + id + '&idCheck=' + id,
            success: function (data) {
                $('#id-' + id).remove();
                $('.content-question[data-count]').each(function (value) {
                    $('#id-' + id).remove();
                    $this = $(this);
                    list_count = parseInt($this.attr('data-count'));
                    list_id = $this.attr('id');
                    if (!(countVote < list_count)) {
                        $('#' + list_id + '').before(data);
                        $('html, body').animate({
                            scrollTop: $('#id-' + id).offset().top
                        }, 2000);
                        return false;
                    }
                    if (!(countVote > list_count)) {
                        $('#wraper').append(data);
                    }
                });
                if (!($("#wraper").find('#id-' + id).length)) {
                    $('#wraper').append(data);
                }
            }
        });

        $('#vote-down-' + id).css({'pointer-events': 'none', 'cursor': 'default'});
        $('#vote-up-' + id).css({'pointer-events': 'auto', 'cursor': 'pointer'});

    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
