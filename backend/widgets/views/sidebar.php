<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\Menu;
?>
<div class="left_col scroll-view">

    <div class="navbar nav_title">
        <a href="<?= Yii::$app->setting->get('siteurl') ?>" class="site_title">
            ADMINSTRATOR
        </a>
        <a href="<?= Yii::$app->setting->get('siteurl') ?>" class="site_title site_title_sm">
            ADMINSTRATOR
        </a>
    </div>
    <div class="clearfix"></div>


    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

        <div class="menu_section ">
            <?php
            echo Menu::widget([
                'items' => [
                    ['label' => '<i class="fa fa-tachometer"></i> Trang chủ', 'url' => ['site/index']],
                    ['label' => '<i class="fa fa-thumb-tack"></i> Danh mục', 'url' => ['category/index']],
                    ['label' => '<i class="fa fa-thumb-tack"></i> Đánh giá', 'url' => ['review/index']],
                    ['label' => '<i class="fa fa-thumb-tack"></i> Bình luận', 'url' => ['comment/index']],
                    ['label' => '<i class="fa fa-thumb-tack"></i> Báo giá<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Danh sách', 'url' => ['rfq/index']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> Sản phẩm' . '<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Sản phẩm chưa duyệt', 'url' => ['product/pending']],
                            ['label' => 'Sản phẩm đã duyệt', 'url' => ['product/verified']],
                            ['label' => 'Sản phẩm đã hết hàng', 'url' => ['product/block']],
                            ['label' => 'Sản phẩm đã hủy', 'url' => ['product/canceled']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> Chứng nhận <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Danh sách', 'url' => ['certification/index']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> Khách hàng <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Danh sách', 'url' => ['customer/index']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> Đơn hàng <span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Đơn hàng đang xử lý', 'url' => ['order/pending']],
                            ['label' => 'Đơn hàng đang giao', 'url' => ['order/sending']],
                            ['label' => 'Đơn hàng không thành công', 'url' => ['order/unsuccessful']],
                            ['label' => 'Đơn hàng thành công', 'url' => ['order/finish']],
                            ['label' => 'Đơn hàng đã hủy', 'url' => ['order/block']]
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> ' . 'Trang' . '<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Trang', 'url' => ['page/index']],
                            ['label' => 'Thêm mới', 'url' => ['page/create']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> ' . 'Quản lý nhà vườn' . '<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Nhà vườn chưa duyệt', 'url' => ['seller/index']],
                            ['label' => 'Nhà vườn đã duyệt', 'url' => ['seller/active']],
                        ],
                    ],
//                    ['label' => '<i class="fa fa-thumb-tack"></i> Nội dung email', 'url' => ['template/index']],
                    ['label' => '<i class="fa fa-user"></i> Thành viên<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Danh sách', 'url' => ['user/index']],
                            ['label' => 'Thêm mới', 'url' => ['user/create']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-user"></i> Báo cáo<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Danh sách', 'url' => ['report/index']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-user"></i> Tin nhắn<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Danh sách', 'url' => ['message/index']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> ' . 'Quản lý diễn đàn' . '<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Câu hỏi', 'url' => ['forum/question']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> ' . 'Tiếng anh' . '<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Dịch', 'url' => ['translationstatic/en']],
                            ['label' => 'Dịch dữ liệu', 'url' => ['translationdata/en']],
                            ['label' => 'Dịch sản phẩm', 'url' => ['translationproduct/en']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-thumb-tack"></i> ' . 'Tiếng việt' . '<span class="fa fa-chevron-down"></span>', 'url' => 'javascript:void(0)', 'items' => [
                            ['label' => 'Dịch', 'url' => ['translationstatic/vi']],
                            ['label' => 'Dịch dữ liệu', 'url' => ['translationdata/vi']],
                        ],
                    ],
                    ['label' => '<i class="fa fa-cog"></i> Cấu hình', 'url' => ['setting/index/config'],
                    ],
                ],
                'encodeLabels' => false,
                'submenuTemplate' => "\n<ul class='nav child_menu' style='display: none'>\n{items}\n</ul>\n",
                'options' => array('class' => 'side-menu nav')
            ]);
            ?>

        </div>


    </div>

</div>
<?php ob_start(); ?>
<script>
    $(".count_notify").html("<?= $count_notify ?>");
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>