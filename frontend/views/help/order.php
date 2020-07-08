<?php 


use yii\bootstrap\Html;

$this->title = "Hướng dẫn xử lý đơn hàng";
$this->params['breadcrumbs'][] = $this->title;

 ?>

 <div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <h3 class="title-guide"><strong>Hướng dẫn cách xử lý đơn hàng trên Vinagex chi tiết</strong></h3>

        <div class="step">
       		<h4 class="title-step"><strong>1. Vào kênh bán hàng của Vinagex</strong></h4>
       		<div class="step-content">
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step1.png&size=846x564'; ?>"></p>
       			<p>Đầu tiên vào trang chủ của <a href="<?= Yii::$app->setting->get('siteurl'); ?>"><strong>Vinagex</strong></a>, bấm vào nút <a href="<?= Yii::$app->setting->get('siteurl_seller'); ?>"><strong>bán hàng cùng vinagex</strong></a> ở góc trên bên phải.</p>
       		</div>
        </div>

         <div class="step">
       		<h4 class="title-step"><strong>2. Vào trang bán hàng trên Vinagex</strong></h4>
       		<div class="step-content">
       			<p>Bấm vào nút <strong>tham gia</strong> hoặc <strong>đăng ký</strong> bán hàng để vào trang quản lý của bạn.</p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step2.png&size=846x564'; ?>"></p>
       		</div>
        </div>

        <div class="step">
       		<h4 class="title-step"><strong>3. Đăng nhập tài khoản</strong></h4>
       		<div class="step-content">
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step3.png&size=846x564'; ?>"></p>
       			<p>Đăng nhập tài khoản Vinagex của bạn vào để vào được trang quản lý bán hàng.</p>
       		</div>
        </div>

        <div class="step">
       		<h4 class="title-step"><strong>4. Xem thông tin và xử lý đơn hàng</strong></h4>
       		<div class="step-content">
       			<p>Sau khi đăng Nhập tài khoản Vinagex thành công các bạn sẽ được chuyển tự động vào trang quản lý bán hàng của <strong>Vinagex</strong></p>
       			<p>Đơn hàng có 3 trạng thái: <strong>Đơn hàng đang xử lý, Đơn hàng đang giao, Đơn hàng đã hoàn thành.</strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/order/step4_1.png&size=1350x690'; ?>"></p>
       			<p><strong>- Đơn hàng đang xử lý: </strong></p>
       			<p>Bấm vào <strong>đơn hàng đang xử lý</strong> để hiển thị danh sách đơn hàng khách hàng đã đặt hàng.</p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/order/step4_2.png&size=1300x700'; ?>"></p>
       			<p>Sau khi chuẩn bị hàng và đã gửi hàng bạn chọn <strong>Giao hàng</strong> để đơn hàng chuyển sang quá trình đang giao hàng.</p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/order/step4_3.png&size=1180x600'; ?>"></p>
       		
       			<p><strong>- Đơn hàng đang giao: </strong></p>
       			<p>Chọn <strong>Đơn hàng đang giao</strong> để hiển thị danh sách đơn hàng đang trong quá trình vận chuyển</p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/order/step4_4.png&size=1180x600'; ?>"></p>
       			<p>Sau khi kiểm tra khách hàng nhận được hàng và đã hài lòng,thì bấm <strong>Đã giao hàng thành công</strong> để chuyển đơn hàng sang <strong>đơn hàng đã hoàn thành</strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/order/step4_5.png&size=1180x600'; ?>"></p>
       			
       			<p><strong>- Đơn hàng đã hoàn thành: </strong></p>
       			<p>Chọn <strong>Đơn hàng đã hoàn thành</strong> để hiển thị danh sách đơn hàng đã giao dịch thành công.</p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/order/step4_6.png&size=1180x600'; ?>"></p>
       			<p>Danh sách đơn hàng đã đưọc giao dịch thành công: </p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/order/step4_7.png&size=1180x600'; ?>"></p>
       			
       		</div>

       		<div class="step">
       		<div class="step-content">
       			<p><strong>* Thực hiện tất cả các bước trên các bạn có thể xử lý đơn hàng một cách dễ dàng hơn.</strong></p>
       		</div>
        </div>


  
    </div>
</div>