<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\Constant;

$this->title = 'Đăng ký bán hàng';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-sm-8 form-seller col-sm-offset-2">
            <h1 style="font-weight: 300; text-align: center; text-transform: uppercase; margin-bottom: 30px">Đăng ký bán hàng cùng Giá tại vườn</h1>
            <p style="text-align: center; margin-bottom: 50px">Bạn đã đăng ký tài khoản bán hàng thành công! <br>
                Chúng tôi đã gởi thông tin tài khoản đăng nhập qua mail, xin vui lòng đọc mail để biết thông tin đăng nhập.</p>
            <p class=" text-center"><a href="/site/login" class="btn btn-primary">ĐĂNG NHẬP</a></p>
        </div>
    </div>
</div>
