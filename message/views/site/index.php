<?php
/* @var $this yii\web\View */


$this->title = 'Nền tảng bán hàng dành cho nhà vườn';
$user = Yii::$app->session['login'];
?>
<div id="chat-realtime">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="text-center">Bạn chưa có cuộc trò chuyện nào!</p>
                </div>
            </div>

        </div>
    </div>
</div>
