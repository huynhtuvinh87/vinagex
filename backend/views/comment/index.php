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
        <div class="col-sm-12 col-xs-12">
            <ul class="action_list">
                <li><a href="/comment/index">Tất cả <span>(<?= $search->getCount() ?>)</span></a></li>
                <li><a href="/comment/index?CommentSearch%5Bstatus%5D=1">Đang chờ <span>(<?= $search->getCount(1) ?>)</span></a></li>
                <li><a href="/comment/index?CommentSearch%5Bstatus%5D=2">Đã duyệt <span>(<?= $search->getCount(2) ?>)</span></a></li>
                <li><a href="/comment/index?CommentSearch%5Bstatus%5D=3">Spam <span>(<?= $search->getCount(3) ?>)</span></a></li>
                <li><a href="/comment/index?CommentSearch%5Bstatus%5D=4">Thùng rác <span>(<?= $search->getCount(4) ?>)</span></a></li>
            </ul>
        </div>
        <div class="col-sm-12 col-xs-12">
            <div class="pull-right">
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
                <button type="submit" class="btn btn-default" style="margin-top: -5px;">Tìm kiếm</button>
                <?php ActiveForm::end(); ?>
            </div>
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
            <div class="pull-left">
                <div class="form-group" style="margin-bottom: 5px">
                    <select name="action" class="form-control">
                        <option>Hành động</option>
                        <option value="delete">Xoá</option>
                        <option value="change">Chỉnh sửa</option>
                    </select>
                </div>
                <button type="submit" id="doaction" class="btn btn-default">Áp dụng</button>
            </div>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn', 'headerOptions' => ['width' => 30]],
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'multiple' => true,
                        'headerOptions' => ['width' => 10]
                    ],
                    [
                        'attribute' => 'Tác giả',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<ul>';
                            $html .= '<li>' . $data->name . '</li>';
                            $html .= '<li>' . $data->email . '</li>';
                            $html .= '<li>' . date('d/m/Y H:i:s', $data->created_at) . '</li>';
                            $html .= '</ul>';
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'content',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<ul>';
                            $html .= '<li>' . $data->content . '</li>';
                            if (!empty($data->answers[$data->count_answer - 1])) {
                                $html .= '<li style="margin-top:10px;"><small>Trả lời gần nhất: ' . $data->answers[$data->count_answer - 1]['content'] . '</small></li>';
                            }
                            switch ($data->status) {
                                case 1:
                                    $html .= '<li class="action"><a href="/comment/status/' . $data->id . '?s=2"><small>Duyệt</small></a><a class="hide" href=""><small>Trả lời</small></a><a href="/comment/status/' . $data->id . '?s=3"><small>Spam</small></a><a href="/comment/status/' . $data->id . '?s=4"><small>Xoá tạm</small></a></li>';
                                    break;
                                case 2:
                                    $html .= '<li class="action"><a class="hide"><small>Duyệt</small></a><a href="javascript:void(0)" class="hide"><small>Trả lời</small></a><a class="hide"><small>Spam</small></a><a href="/comment/status/' . $data->id . '?s=4"><small>Xoá tạm</small></a></li>';
                                    break;
                                case 3:
                                    $html .= '<li class="action"><a href="/comment/status/' . $data->id . '?s=2"><small>Duyệt</small></a><a class="hide" href=""><small>Trả lời</small></a><a class="hide"><small>Spam</small></a><a href="/comment/status/' . $data->id . '?s=4"><small>Xoá tạm</small></a></li>';
                                    break;
                                case 4:
                                    $html .= '<li class="action"><a href="/comment/status/' . $data->id . '?s=2"><small>Duyệt</small></a><a class="hide" href=""><small>Trả lời</small></a><a class="hide"><small>Spam</small></a>' . Html::a('<small>Xoá</small>', ['delete', 'id' => $data->id], [
                                                'title' => 'Xoá',
                                                'data-confirm' => Yii::t('yii', 'Bạn có muốn xoá bình luận này không?'),
                                                'data-method' => 'post']) . '</li>';
                                    break;
                            }
                            $html .= '</ul>';
                            return $html;
                        }
                    ],
                    [
                        'attribute' => 'Trả lời cho',
                        'format' => 'raw',
                        'value' => function($data) {
                            $html = '<ul>';
                            $html .= '<li><a href="' . Yii::$app->setting->get('siteurl') . '/' . $data->product['slug'] . '-' . $data->product['id'] . '"><strong>' . $data->product['title'] . '</strong></a></li>';
                            $html .= '<li style="margin-bottom:5px;"><a href="' . Yii::$app->setting->get('siteurl') . '/' . $data->product['slug'] . '-' . $data->product['id'] . '"><small>Xem sản phẩm</small></a></li>';
                            if ($data->count_answer > 0) {
                                if (!empty(array_count_values(array_column($data['answers'], 'status'))[1])) {
                                    $count = array_count_values(array_column($data['answers'], 'status'))[1];
                                } else {
                                    $count = 0;
                                }
                                $html .= '<li><span class="icon-comment">' . $data->count_answer . '</span> <a href="javascript:void(0)" class="answer_view" style="color:#5cb85c" data-id="' . $data->id . '"><small>Xem tất cả</small></a> <small>Chưa duyệt (' . $count . ')</small></li>';
                            }
                            $html .= '<li class="list_answer" style="margin-top:10px;" id="list-answer-' . $data->id . '"></li>';
                            $html .= '</ul>';
                            return $html;
                        }
                    ],
                ],
            ]);
            ?>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
<?= $this->registerJs("
$(document).ready(function() {
    $('form#commentAction button[type=submit]').click(function() {
         return confirm('Bạn có muốn thực hiện yêu cầu này không?');
    });
});
") ?>
<?php ob_start(); ?>
<script type="text/javascript">
    $("body").on("click", ".answer_view", function (event, state) {
        $(".list_answer").html("");
        var id = $(this).attr("data-id");
        $.get('/comment/answer/' + id, function (data) {
            $("#list-answer-" + id).html(data);
        });
        return false;
    });
    $("body").on("click", ".answer_delete", function (event, state) {
        if (confirm('Bạn có muốn xoá câu trả lời này không?')) {
            $.ajax({
                type: "POST",
                url: '/ajax/commentdelete',
                data: {id: $(this).attr("data-id"), key: $(this).attr("data-key")},
                success: function (data) {
                    $.pjax({container: '#pjax-grid-comment'});
                    return false;
                },
            });

        }

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