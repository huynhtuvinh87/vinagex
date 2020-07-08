<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use common\components\Constant;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bình luận';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6 col-comment-action">
            <ul class="action_list">
                <li><a href="/comment/index?CommentSearch%5Bstatus%5D=1">Đang chờ <span>(<?= $search->getCountSeller(1) ?>)</span></a></li>
                <li><a href="/comment/index?CommentSearch%5Bstatus%5D=2">Đã duyệt <span>(<?= $search->getCountSeller(2) ?>)</span></a></li>
            </ul>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 col-comment-search">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'GET',
                        'options' => [
                            'class' => 'form-inline'
                        ]
            ]);
            ?>
            <?= $form->field($search, 'keywords')->textInput()->label(FALSE) ?>

            <button type="submit" class="btn btn-default" style="margin-top: -10px;">Tìm kiếm</button>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php Pjax::begin(['id' => 'pjax-grid-comment']); ?>  

            <?php
            $form = ActiveForm::begin([
                        'id' => 'commentAction',
                        'action' => ['doaction'],
                        'options' => [
                            'class' => 'form-inline'
                        ]
            ]);
            ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-bordered table-customize table-responsive'],
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                    [
                        'attribute' => 'Tác giả',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<div class="left">';
                            $html .= '<strong>Tác giả: </strong>';
                            $html .= '</div>';
                            $html .= '<div class="right">';
                            $html .= '<ul>';
                            $html .= '<li>' . $data->name . '</li>';
                            $html .= '<li>' . $data->email . '</li>';
                            $html .= '</ul>';
                            $html .= '</div>';
                            $html .= '<div style="clear: both;"></div>';
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'content',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<div class="left">';
                            $html .= '<strong>Bình luận: </strong>';
                            $html .= '</div>';
                            $html .= '<div class="right">';
                            $html .= '<ul>';
                            $html .= '<li>' . $data->content . '</li>';
                            if ($data->count_answer > 0) {
                                $html .= '<li style="margin-top:10px;"><small>Trả lời gần nhất: ' . $data->answers[$data->count_answer - 1]['content'] . ' (' . date('d/m/Y H:i:s', $data->answers[$data->count_answer - 1]['created_at']) . ')</small></li>';
                            }
                            if ($data->status == 1) {
                                $html .= '<li class="action"><a href="/comment/status/' . $data->id . '?s=2"><small>Duyệt</small></a></li>';
                            } else {
                                $html .= '<li class="action"><a href="javascript:void(0)" class="answer" style="color:#5cb85c" data-id="' . $data->id . '"><small>Trả lời</small></a></li>';
                            }
                            $html .= '<li class="form-content" id="form-content-' . $data->id . '"></li>';
                            $html .= '</ul>';
                            $html .= '</div>';
                            $html .= '<div style="clear: both;"></div>';
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'Trả lời',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<div class="left">';
                            $html .= '<strong>Trả lời cho: </strong>';
                            $html .= '</div>';
                            $html .= '<div class="right">';
                            $html .= '<ul>';
                            $html .= '<li><a href="' . Yii::$app->setting->get('siteurl') . '/' . $data->product['slug'] . '-' . $data->product['id'] . '"><strong>' . $data->product['title'] . '</strong></a></li>';
                            $html .= '<li style="margin-bottom:5px;"><a href="' . Yii::$app->setting->get('siteurl') . '/' . $data->product['slug'] . '-' . $data->product['id'] . '"><small>Xem sản phẩm</small></a></li>';
                            if ($data->count_answer > 0) {
                                $html .= '<li><span class="icon-comment">' . $data->count_answer . '</span> <a href="javascript:void(0)" class="answer_view" style="color:#5cb85c" data-id="' . $data->id . '"><small>Xem tất cả</small></a></li>';
                            }
                            $html .= '<li class="list_answer" style="margin-top:10px; line-height: 10px;" id="list-answer-' . $data->id . '"></li>';
                            $html .= '</ul>';
                            $html .= '</div>';
                            $html .= '<div style="clear: both;"></div>';
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'Ngày đăng',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<div class="left">';
                            $html .= '<strong>Ngày đăng: </strong>';
                            $html .= '</div>';
                            $html .= '<div class="right">';
                            $html .= date('d/m/Y H:i:s',$data->created_at);
                            $html .= '</div>';
                            $html .= '<div style="clear: both;"></div>';
                            return $html;
                        },
                    ],
                ],
            ]);
            ?>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<?php ob_start(); ?>
<script type="text/javascript">
    function getFormComment(id) {
        var html = '';
        html += '<input type="hidden" name="comment_id" value="' + id + '">';
        html += '<textarea name="content" id="comment_content" class="form-control" style="width:100%"></textarea><br>';
        html += '<p class="comment_error"></p>';
        html += '<button type="button" id="send" class="btn btn-primary pull-right btn-sm" style="margin-top:5px; width:auto">Gửi</button> <button type="button" class="btn btn-default pull-right cancel btn-sm" style="margin-top:5px; margin-right:5px; width:auto">Huỷ</button>';
        return html;
    }

    $("body").on("click", ".answer", function (event, state) {
        var id = $(this).attr("data-id");
        $(".form-content").html("");
        $(".answer-form").html("");
        $("#form-content-" + id).html(getFormComment(id));
    });
    $("body").on("click", ".answer_view", function (event, state) {
        $(".list_answer").html("");
        var id = $(this).attr("data-id");
        $.get('/comment/answer/' + id, function (data) {
            $("#list-answer-" + id).html(data);
        });
        return false;
    });

    $("body").on("click", ".cancel", function (event, state) {
        $(".form-content").html("");
    });

    $("body").on("click", "#send", function (event, state) {
        var name = '<?= Yii::$app->user->identity->garden_name ?>';
        var content = '@' + name + ': ' + $("#comment_content").val();
        if (content == "") {
            $(".comment_error").html('Bạn chưa nhập bình luận');
            return false;
        }
        $.ajax({
            type: "POST",
            url: '/ajax/comment',
            data: $("#commentAction").serialize(),
            success: function (data) {
                $.pjax({container: '#pjax-grid-comment'});
            },
        });

        return false;
    });

    $("body").on("click", ".answer_cancel", function (event, state) {
        $(".list_answer").html("");
    });
    function getFormAnswer(name,id) {

        var html = '';
        html += '<input type="hidden" name="comment_id" value="'+id+'">';
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
        $("#answer-form-" + id).html(getFormAnswer(name,id));
    });
    $("body").on("click", ".cancel_reply", function (event, state) {
        $(".answer-form").html("");
    });

    $("body").on("click", ".answer_status", function (event, state) {
        $.ajax({
            type: "POST",
            url: '/ajax/commentstatus',
            data: {comment_id: $(this).attr("data-id"), key: $(this).attr("data-key")},
            success: function (data) {
                $.pjax({container: '#pjax-grid-comment'});
                return false;
            },
        });

    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>