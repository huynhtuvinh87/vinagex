<?php 


use yii\bootstrap\Html;

$this->title = "Hướng dẫn đăng sản phẩm";
$this->params['breadcrumbs'][] = $this->title;

 ?>

 <div class="panel panel-default">
    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
    <div class="panel-body">
        <h3 class="title-guide"><strong>Hướng dẫn cách đăng sản phẩm trên Vinagex chi tiết</strong></h3>

        <div class="step">
       		<h4 class="title-step"><strong>1. Vào kênh bán hàng của Vinagex</strong></h4>
       		<div class="step-content">
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step1.png&size=846x564'; ?>"></p>
       			<p>Đầu tiên vào trang chủ của <a href="<?= Yii::$app->setting->get('siteurl'); ?>"><strong>Vinagex</strong></a>, bấm vào nút <a href="<?= Yii::$app->setting->get('siteurl_seller'); ?>"><strong>bán hàng cùng vinagex</strong></a> ở góc trên bên phải.</p>
       		</div>
        </div>

        <div class="step">
       		<h4 class="title-step"><strong>2. Tham gia bán hàng trên Vinagex</strong></h4>
       		<div class="step-content">
       			<p>Sau khi vào là phần giới thiệu kênh bánh hàng. Bấm vào nút <strong>tham gia</strong> hoặc <strong>đăng ký</strong> bán hàng để vào đăng sản phẩm của bạn.</p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step2.png&size=846x564'; ?>"></p>
       		</div>
        </div>

        <div class="step">
       		<h4 class="title-step"><strong>3. Đăng nhập tài khoản</strong></h4>
       		<div class="step-content">
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step3.png&size=846x564'; ?>"></p>
       			<p>Đăng nhập tài khoản Vinagex của bạn vào để vào được trang bán hàng. Nếu chưa có tài khoản thì chọn <strong>đăng ký tài khoản</strong>.</p>
       		</div>
        </div>

        <div class="step">
       		<h4 class="title-step"><strong>4. Thiết lập thông tin bán hàng</strong></h4>
       		<div class="step-content">
       			<p>Sau khi đăng Nhập tài khoản Vinagex thành công các bạn sẽ được chuyển tự động vào trang quản lý bán hàng của <strong>Vinagex</strong></p>
       			<p>Bấm vào <strong>Thông tin chung</strong> để thiết lập thông tin cho nhà bán hàng.</p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step4.png&size=1000x500'; ?>"></p>
       			<p><strong>Thiết lập thông tin cho tài khoản bán hàng Vinagex rất quan trọng. Hình ảnh phải cụ thể, thông tin rõ ràng là các yêu cầu tối thiểu:</strong></p>
       			<p><strong>Thông tin của Chủ nhà vườn: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step5_1.png&size=1000x150'; ?>"></p>
       			<p><strong>Thông tin của vườn: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step5_2.png&size=1500x700'; ?>"></p>
       			<p><strong>Phần hình ảnh của nhà vườn cũng quan trọng, yêu cầu tối thiểu là 3 hình ảnh, kích thước 450x450, và là hình thật của nhà vườn. </strong></p>
       			<p><strong>Nếu vườn có chứng nhận thì yêu cầu chụp mặt trước của giấy chứng nhận và điền thông tin ngày cấp và nơi cấp của chứng nhận đó.</strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step5_3.png&size=1500x1000'; ?>"></p>
       			<p>Sau khi kiểm tra lại, bấm cập nhật và vui lòng đợi <strong>Vinagex xác minh nhà vườn của bạn</strong>.</p>
       		</div>
        </div>

        <div class="step">
       		<h4 class="title-step"><strong>5. Đăng sản phẩm</strong></h4>
       		<div class="step-content">
       			<p>Khi nhà vườn của bạn đã được xác minh thành công thì tài khoản của bạn đã có thể đăng sản phẩm.</p>
       			<p>Bấm vào nút <strong>Thêm sản phẩm</strong> ở góc trên bên phải hoặc <strong>Đăng sản phẩm</strong> ở menu trái để đang sản phẩm của bạn.</p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step_6.png&size=1500x800'; ?>"></p>
       			<p>Sau khi chọn đăng sản phẩm thì form nhập thông tin sản phẩm được hiển thị: </p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7.png&size=1500x800'; ?>"></p>
       			<p><strong>- Nhập tên sản phẩm: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_1.png&size=1100x50'; ?>"></p>
       			<p><em><small>+ Tên sản phẩm cùng một vườn không được trùng nhau.</small></em></p>

       			<p><strong>- Chọn danh mục sản phẩm: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_2.png&size=1100x50'; ?>"></p>
       			<p><em><small>+ Danh mục sản phẩm phải đúng với tên sản phẩm của bạn.</small></em></p>
       			<p><em><small>+ Sau khi chọn danh mục sẽ hiển thị chi tiết gồm tên và đơn vị tính cho sản phẩm:</small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_3.png&size=1105x200'; ?>"></p>

       			<p><strong>- Nhập mô tả cho sản phẩm: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_4.png&size=1100x200'; ?>"></p>
       			<p><em><small>+ Hãy cho mọi người biết sản phẩm của bạn có gì đặt biệt.</small></em></p>
       			<p><strong>- Nhập khu vực mà bạn sẽ bán sản phẩm: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_5.png&size=1100x200'; ?>"></p>
       			<p><em><small>+ Chọn tỉnh thành mà bạn muốn bán sản phẩm.</small></em></p>


       			<p><strong>- Nhập gía của sản phẩm: </strong></p>
       			<p><strong>* Lưu ý: Gồm có 3 loại gía: </strong></p>

       			<p><strong>Loại 1: <small>Chỉ có 1 gía và số lượng của sản phẩm</small></strong></p>
       			<p><em><small>+ Nhập vào số lượng mà bạn cho phép bán thấp nhất và gía của sản phẩm.</small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_1_1.png&size=1000x150'; ?>"></p>

       			<p><strong>Loại 2: <small>Có nhiều gía và số lượng của sản phẩm</small></strong></p>
       			<p><em><small>+ Nếu sản phẩm của bạn có từ hai đơn gía theo số lượng trở lên thì chọn vào <strong>thêm khung gía</strong> :</small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_6.png&size=900x50'; ?>"></p>

       			<p><em><small>+ Sau đó bạn nhập số lượng và gía theo ý muốn và bấm <strong>thêm khung gía</strong> để nhập khung gía tiếp theo: </small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_7.png&size=1100x100'; ?>"></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_8.png&size=1100x200'; ?>"></p>
       			<p><em><small>+ Chọn <strong>xóa</strong> nếu muốn bỏ bớt khung gía cho sản phẩm.</small></em></p>
       			<p><em><small>+ Nhập gía sản phẩm có thể dao động: </small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_9.png&size=1000x50'; ?>"></p>

       			<p><strong>Loại 3: <small>Có nhiều loại, số lượng, gía của sản phẩm</small></strong></p>
       			<p><em><small>+  Nếu sản phẩm của bạn có <strong>nhiều</strong> loại, số lượng, đơn gía thì chọn vào <strong>Thêm phân loại hàng</strong></small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_1_2.png&size=1000x150'; ?>"></p>
       			<p><em><small>+  Nhập mô tả, số lượng, gía sản phẩm của bạn cần bán.</small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_1_3.png&size=1100x200'; ?>"></p>
       			<p><em><small>+  Nếu <strong>nhiều khung gía theo số lượng</strong> thì chọn vào tạo khoảng gía.</small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_1_4.png&size=1100x200'; ?>"></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_1_5.png&size=1100x300'; ?>"></p>
       			<p><em><small>+  Chọn <strong>Thêm phân loại hàng</strong> để thêm loại cho sản phẩm.</small></em></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_1_6.png&size=1110x350'; ?>"></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_1_7.png&size=1100x460'; ?>"></p>

       			<p><strong>- Chọn hình thức vận chuyển: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_10.png&size=900x50'; ?>"></p>
       			<p><em><small>+ Hình thức vận chuyển cho phép nhà vườn tự thỏa thuận với người mua hoặc thông qua <strong>Vinagex</strong> để đảm bảo vận chuyển sản phẩm an toàn.</small></em></p>

       			<p><strong>- Chọn hình ảnh cho sản phẩm: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_11.png&size=1120x400'; ?>"></p>
       			<p><em><small>+ Bấm vào <strong>Tải hình ảnh từ máy tính</strong> để tải hình sản phẩm lên. Lưu ý <strong>tối thiểu là 3 hình</strong>, <strong>kích thước 450x450</strong> và quan trọng phải là <strong>hình ảnh thật</strong> của sản phẩm.</small></em></p>

       			<p><strong>- Thời gian bán: </strong></p>
       			<p><img src="<?= Yii::$app->setting->get('siteurl_cdn') . '/image.php?src=images/guide/step7_1_12.png&size=1120x200'; ?>"></p>
       			<p><em><small>+ Nếu bạn đã có hàng sẵng sàng thì chọn <strong>Tôi đã có hàng và sẵng sàng giao</strong>.</small></em></p>
       			<p><em><small>+ Ngược lại nếu bạn chưa có hàng sẵng sàng giao và muốn đặt lệnh bán trước thì chọn <strong>Tôi chưa có hàng và tôi muốn đặt lệnh bán trước</strong> và <strong>nhập khoảng thời gian sẽ có hàng</strong> để khách hàng đặt trước.</small></em></p>
       			<p><strong>Sau khi kiểm tra lại toàn bộ thông tin sản phẩm, bấm đăng sản phẩm.</strong></p> 
       			<p><strong>* Vậy là sản phẩm đã được đăng thành công, <strong>xin vui lòng đợi Vinagex xét duyệt sản phẩm của bạn. Sau khi duyệt thành công thì sản phẩm của bạn sẽ được hiển thị trên trang chủ của Vinagex.</strong></strong></p>			
       		</div>
        </div>

    </div>
</div>