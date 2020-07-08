<?php

use common\components\Constant;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Đặt hàng thành công</title>
    </head>
        <table style="width: 640px; margin: 0 auto; border: 1px solid #ddd; font-family: 'Open Sans', Arial, sans-serif;">
            <tr>
                <th style="text-align: left; border-bottom: 1px solid #ddd;padding: 5px 0">Tên sản phẩm</th>
                <th style="text-align: left; border-bottom: 1px solid #ddd;padding: 5px 0">Số lượng</th>
                <th style="text-align: left; border-bottom: 1px solid #ddd;padding: 5px 0">Thành tiền</th>
            </tr>
            <?php
            foreach ($data['data']['product'] as $key => $item) {
                ?>
                <tr>
                    <td style="padding: 5px 0"><?= $item['title'] ?></td>
                    <td style="padding: 5px 0"><?= $item['quantity'] ?></td>
                    <td style="padding: 5px 0"><?= Constant::price($item['price'] * $item['quantity']) ?> VNĐ</td>
                </tr>
                <?php
            }
            ?>
        </table>

    </body>
</html>
<?php
exit;
?>