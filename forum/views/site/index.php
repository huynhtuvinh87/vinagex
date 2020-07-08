<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use common\components\Constant;
if(isset($_GET['category']) && $_GET['category'] != NULL){
    $category_title = $category[array_search($_GET['category'], array_column($category, '_id'))]['title'];
}else{
    $category_title = 'Danh mục';
}
?>                          
<div class="container">
    <div class="row nopadding subheader">
        <div class="col-md-8 nopadding">
            <?php $form = ActiveForm::begin(['action' => ['search/index'], 'id' => 'form-search', 'method' => 'get']); ?>
            <div class="has-feedback group-search">
                <div class="input-group">
                    <span class="input-group-addon">
                        <div class="dropdown show">
                            <a class="btn-sm btn-secondary dropdown-toggle title" href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $category_title ?> <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown" aria-labelledby="dropdownMenuLink">
                                <li><a id="cate-all"  class="dropdown-item item-category" href="javascript:void(0)">Danh mục</a></li>
                                <?php foreach ($category as $value) { ?>
                                    <li ><a id="cate-<?= $value->id; ?>" data="<?= $value->id; ?>" class="dropdown-item item-category" href="javascript:void(0)"><?= $value->title; ?></a></li>
                                <?php } ?>
                            </div>
                        </div>
                    </span>
                    <input class="form-control text-search" value="<?= isset($_GET['keywords'])?$_GET['keywords']:'' ?>" type="text" name="keywords" placeholder="<?= (!empty(Yii::$app->session->getFlash('alert'))) ? Yii::$app->session->getFlash('alert') : 'Tìm kiếm ...'; ?>">
                </div> 
                <input id="sort" type="hidden" name="" value="">
                <input id="category" type="hidden" name="category" value="">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span>', ['class' => 'btn-search']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4 nopadding">
            <div class="add-question pull-right">
                <?php if (Yii::$app->user->isGuest) { ?>
                    <p><a href="<?= Yii::$app->setting->get('siteurl_id') . '/login?url=' . Constant::redirect(Yii::$app->urlManager->createAbsoluteUrl(['/'])) ?>"  data-title="Tạo mới câu hỏi">Đăng câu hỏi</a></p>
                <?php } else { ?>
                    <p><a href="/question/create" class="post-question" data-title="Tạo mới câu hỏi">Đăng câu hỏi</a></p>
                <?php } ?>
            </div>
        </div>
    </div>


    <div class="qlist">
        <div class="row">
            <div class="col-md-8">
                <h3 class="title-list-question"><?= $this->title ?></h3>  
                <?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => [
                          'class' => 'list-question',
                    ],
                    'emptyText' => 'Chưa có câu hỏi nào.',
                    'layout' => "{items}\n<div class='row'><div class='col-sm-12 pagination-page'>{pager}</div></div>",
                    'itemView' => '/question/_item',
                ]);
                ?>
            </div>
            <div class="col-md-4">
                <div class="right">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4>Các câu hỏi mới</h4></div>
                        <div class="panel-body">

                            <?php foreach ($question->newQuestion() as $value) { ?>
                                <!--item -->
                                <div class="news-questions">
                                    <a href="/question/view/<?= $value->id ?>"><?= $value->title ?></a>
                                    <p><small>Trả lời: <?= $value->total_answer; ?> | Đã hỏi bởi <a data-profile="<?= $value->id; ?>" class="name" href="<?= Yii::$app->setting->get('siteurl').'/user/view/'.$value->user['id'] ?>"><?= $value->user['fullname'] ?></a></small></p>
                                </div>
                                <!-- end item -->
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4>Top bình chọn</h4></div>
                        <div class="panel-body">

                            <?php foreach ($question->ratingQuestion() as $value) { ?>
                                <!--item -->
                                <div class="news-questions">
                                    <a href="/question/view/<?= $value->id ?>"><?= $value->title ?></a>
                                    <p><small>Trả lời: <?= $value->total_answer; ?> | Đã hỏi bởi <a data-profile="<?= $value->id; ?>" class="name-user" href="<?= Yii::$app->setting->get('siteurl').'/user/view/'.$value->user['id'] ?>"><?= $value->user['fullname'] ?></a></small></p>
                                </div>
                                <!-- end item -->
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h4>Trả lời nhiều nhất</h4></div>
                        <div class="panel-body">

                            <?php foreach ($question->answerQuestion() as $value) { ?>
                                <!--item -->
                                <div class="news-questions">
                                    <a href="/question/view/<?= $value->id ?>"><?= $value->title ?></a>
                                    <p><small>Trả lời: <?= $value->total_answer; ?> | Đã hỏi bởi <a data-profile="<?= $value->id; ?>" class="name-user" href="<?= Yii::$app->setting->get('siteurl').'/user/view/'.$value->user['id'] ?>"><?= $value->user['fullname'] ?></a></small></p>
                                </div>
                                <!-- end item -->
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- item -->

</div>


<?=
$this->registerJs("
        $('body').on('click', '.post-question', function(event) {
            $('#modalHeader span').html($(this).attr('data-title'));
            $.get($(this).attr('href'), function(data) {
              $('#modal-question').modal('show').find('#modalContent').html(data)
           });
           return false;
        });
        
");
?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>Thống kê chi tiết</span>',
    'id' => 'modal-question',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style=\"text-align:center\"><img src=\"my/path/to/loader.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>

<?php ob_start(); ?>
<script>

    var homeUrl = window.location.pathname;
    if (homeUrl == $('#tabs-home').attr('href') || homeUrl == '/') {
        $('#tabs-home').addClass('active');
    }

//    $(".tabs a").on("click", function () {
//        $('input#sort').attr('name', $(this).attr('data'));
//        $('input#sort').val($(this).attr('data'));
//        $('#form-search').submit();
//    });

    $(".item-category").on("click", function () {
        $('.title').html($(this).html() + '<span class="caret"></span>');
        $('#category').val($(this).attr('data'));
        $('.text-search').attr('placeholder', 'Tìm kiếm câu hỏi theo: ' + $(this).html() + ' ...');
    });

    $('.list-question .name-user').bind('mouseenter', function () {
        var id = $(this).attr('data-profile');
        $('#profile-' + id).show();
    });
    $('.list-question .name-user').bind('mouseleave', function () {
        var id = $(this).attr('data-profile');
        $('#profile-' + id).hide();
    });


    $("body").on("click", ".vote-up", function (event) {
        var id = $(this).attr('data-id');
        var countVote = parseInt($('#vote-' + id).html());
        countVote = countVote + 1;
        $('#vote-' + id).html(countVote);


        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/vote"]); ?>',
            type: 'post',
            data: 'idVote=' + id + '&idCheck=' + id,
            success: function (data) {
                $('#item-' + id).remove();
                $('.item[data-count]').each(function (value) {
                    $('#item-' + id).remove();
                    $this = $(this);
                    var list_count = parseInt($this.attr('data-count'));
                    var list_id = $this.attr('id');
                    if (!(countVote > list_count)) {
                        $('#' + list_id + '').after(data);
                    } else {
                        if (countVote == list_count) {
                            return false;
                        } else {
                            $('#' + list_id + '').before(data);
                            return false;
                        }
                    }
                });
                if (!($(".list-question").find('#item-' + id).length)) {
                    $('.list-question').append(data);
                }

                $('html, body').animate({
                                scrollTop: $('#item-' + id).offset().top
                            }, 2000);

                $('#vote-up-' + id).css({'pointer-events': 'none', 'cursor': 'default'});
                $('#vote-down-' + id).css({'pointer-events': 'auto', 'cursor': 'pointer'});

            }
        });

    });

    $("body").on("click", ".vote-down", function (event) {
        var id = $(this).attr('data-id');
        var countVote = parseInt($('#vote-' + id).html());
        countVote = countVote - 1;
        $('#vote-' + id).html(countVote);

        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(["question/vote"]); ?>',
            type: 'post',
            data: 'idUnvote=' + id + '&idCheck=' + id,
            success: function (data) {
                $('#item-' + id).remove();
                $('.item[data-count]').each(function (value) {
                    $('#item-' + id).remove();
                    $this = $(this);
                    list_count = parseInt($this.attr('data-count'));
                    list_id = $this.attr('id');
                    if (!(countVote < list_count)) {
                        $('#' + list_id + '').before(data);
                        return false;
                    }
                    if (!(countVote > list_count)) {
                        $('.list-question').append(data);
                    }
                });

                if (!($(".list-question").find('#item-' + id).length)) {

                    $('.list-question').append(data);
                }

                $('html, body').animate({
                                scrollTop: $('#item-' + id).offset().top
                            }, 2000);
            }
        });

        $('#vote-down-' + id).css({'pointer-events': 'none', 'cursor': 'default'});
        $('#vote-up-' + id).css({'pointer-events': 'auto', 'cursor': 'pointer'});

    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
