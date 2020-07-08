<?php

use common\components\Constant;

?>
     <div class="content-notification">
            <ul class="list-item">
            <?php 
            if(!empty($notification)){
                foreach ($notification as $value) { ?>
                    <li id="item-<?= $value['_id'] ?>" class="item <?= $value['status'] == 0?'noactive':'active'?>">
                        
                        <div class="pull-left">
                            <a data-id="<?= $value['_id'] ?>" href="javascript:void(0)" class="read" data-href="<?= $value['url'] ?>">
                            <p><?= $value['content'] ?></p>
                            <p class="time"><i class="fas fa-clock"></i> <?= Constant::time($value['created_at']) ?></p>
                            </a>
                        </div>
                        <div class="pull-right">
                            <a class="check-read" data-id="<?= $value['_id'] ?>" title="<?= $value['status'] == 0?'Đánh dấu đã đọc':'Đánh dấu chưa đọc' ?>" href="javascript:void(0)"><i class="fa fa-eye"></i></a>
                        </div>
                    </li>
            <?php 
                }
            }else{
                echo "Chưa có thông báo bán hàng nào!";
            }
            ?>
            </ul>
        </div>