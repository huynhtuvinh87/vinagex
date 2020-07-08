<?php 
    use common\components\Constant;
?>
    <div class="comp-content">
            <?php
            if ($static) {
                $totalQtt = array_sum(array_column($static, 'totalQtt'));
            ?>
            <div id="seller-static">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr><th>Sản phẩm</th><th>Số lượng bán</th><th>Doanh thu</th><th></th></tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($static as $value) {
                    ?>
                        <tr>
                            <td><?= $value['_id']['product']['title'] ?></td>
                            <td><?= $value['totalQtt'] ?> <?= $value['_id']['product']['unit'] ?></td>
                            <td><?= Constant::price($value['totalAmount']) ?> vnđ</td>
                            <td><a href="/site/static/<?= $value['_id']['product']['id'] ?>" class="static_item" data-title="<?= $value['_id']['product']['title'] ?>">Chi tiết</a></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            }else{
                echo "<div style='margin-top: 20px'>Chưa có đơn hàng thành công nào!</div>";
            }
            ?>
        </div>