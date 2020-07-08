<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>
<section class=" job-bg page  ad-profile-page">
    <div class="container">
        <?= \frontend\widgets\MemberMenu::widget() ?>
        
        <div class="resume-content">
            <div class="personal-deatils section">
                <div class="icons">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                </div>  
                <div class="personal-info">
                    <h3>Thông tin cá nhân <small><?= Html::a('Chỉnh sửa',['update'],['class'=>'btn btn-primary pull-right'])?></small></h3>
                    <ul class="address">
                        <li><h5>Họ và Tên </h5> <span>:</span><?= $model->name ?></li>
                        <li><h5>Tên tài khoản </h5> <span>:</span><?= $model->username ?></li>
                        <li><h5>Email </h5> <span>:</span><?= $model->email ?></li>
                        <li><h5>Điện thoại </h5> <span>:</span><?= $model->phone ?></li>
                        <li><h5>Ngày sinh </h5> <span>:</span><?= $model->birthday ?></li>
                        <li><h5>Giới tính </h5> <span>:</span><?= $model->gender == 1 ? 'Nam' : 'Nữ' ?></li>
                        <li><h5>Địa chỉ </h5> <span>:</span><?= $model->address ?></li>
                        <li><h5>Tỉnh/Thành </h5> <span>:</span><?= $model->city ?></li>
                       
                    </ul>    	
                </div>                               
            </div><!-- personal-deatils -->	



        </div><!-- resume-content -->						
    </div><!-- container -->
</section><!-- ad-profile-page -->
