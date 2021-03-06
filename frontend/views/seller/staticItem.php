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
            <tr><th><?= \Yii::t('common', 'Tỉnh thành') ?></th><th><?= \Yii::t('common', 'Số lượng') ?></th><th><?= \Yii::t('common', 'Doanh thu') ?></th><th><?= \Yii::t('common', 'Tỷ lệ %') ?></th></tr>
        </thead>
        <tbody>
            <?php
            $totalQtt = array_sum(array_column($static, 'totalQtt'));
            foreach ($static as $value) {
                ?>
                <tr>
                    <td data-title="<?= \Yii::t('common', 'Tỉnh thành') ?>: "><?= $value['_id']['province']['name'] ?></td>
                    <td data-title=<?= \Yii::t('common', 'Số lượng') ?>": "><?= $value['totalQtt'] ?> <?= Yii::t('common', $value['_id']['province']['unit']) ?></td>
                    <td data-title=<?= \Yii::t('common', 'Doanh thu') ?>": "><?= Constant::price($value['totalAmount']) ?> vnđ</td>
                    <td data-title=<?= \Yii::t('common', 'Tỷ lệ %') ?>": "><?= round($value['totalQtt'] / $totalQtt * 100, 2) ?> %</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
}
?>
