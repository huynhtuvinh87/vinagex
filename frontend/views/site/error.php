<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container">
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            Đã xảy ra lỗi máy chủ nội bộ
        </div>

        <p>
           Lỗi trên xảy ra khi máy chủ Web đang xử lý yêu cầu của bạn.
        </p>
        <p>
            Vui lòng liên hệ với chúng tôi nếu bạn cho rằng đây là lỗi máy chủ. Cảm ơn bạn.
        </p>

    </div>
</div>