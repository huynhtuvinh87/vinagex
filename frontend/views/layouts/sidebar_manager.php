<ul class="list-group">
    <li class="list-group-item"><a href="/manager/seller/index">Tổng quan nhà vườn</a></li>
    <li class="list-group-item">Đăng sản phẩm
        <ul style="margin-left: 20px">
            <?php
            foreach (common\components\Constant::category() as $key => $value) {
                ?>
            <li style="padding: 5px 0"><a href="/manager/product/create?id=<?=$key?>"><?=$value?></a></li>
                <?php
            }
            ?>
        </ul>
    </li>
    <li class="list-group-item"><a href="/manager/product/index">Sản phẩm</a></li>
    <li class="list-group-item"><a href="/manager/product/pending">Sản phẩm chờ duyệt</a></li>
    <li class="list-group-item">Sản phẩm đang bán</li>
    <li class="list-group-item">Đơn hàng đã hoàn thành</li>
    <li class="list-group-item">Đơn hàng đang xử lý</li>
    <li class="list-group-item">Thống kê</li>
    <li class="list-group-item">Thay đổi mật khẩu</li>
    <li class="list-group-item">Thoát</li>
</ul>