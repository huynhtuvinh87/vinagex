<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use common\components\Constant;

if ($static) {
    ?>
    <table class="table table-striped table-bordered table-responsive">
        <thead>
            <tr><th>Tỉnh thành</th><th>Số lượng bán</th><th>Doanh thu</th><th>Tỉ lệ %</th></tr>
        </thead>
        <tbody>
            <?php
            $totalQtt = array_sum(array_column($static, 'totalQtt'));
            foreach ($static as $value) {
                ?>
                <tr>
                    <td data-title="Tỉnh thành: "><?= $value['_id']['province']['name'] ?></td>
                    <td data-title="Số lượng bán: "><?= $value['totalQtt'] ?> <?= $value['_id']['province']['unit'] ?></td>
                    <td data-title="Doanh thu: "><?= Constant::price($value['totalAmount']) ?> vnđ</td>
                    <td data-title="Tỉ lệ %: "><?= round($value['totalQtt'] / $totalQtt * 100, 2) ?> %</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>
