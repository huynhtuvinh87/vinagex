<?php 
use common\components\Constant;
 ?>


<div class="container">
	<?php if($model->status == Constant::STATUS_ORDER_BLOCK){ ?>
		<h4>Lý do hủy đơn hàng: </h4>
            <?php 
            	 if (!empty($model->content)) {
                            foreach ($model->content as $reason) {
                                echo '<p>- ' . $reason . '</p>';
                            }
                    } else {
                        echo '<p>- Đơn hàng bị hủy tự động do trong vòng 24h nhà cung cấp không xử lý đơn hàng.</p>';
                    }
            ?>
	<?php }else if($model->status == Constant::STATUS_ORDER_UNSUCCESSFUL){ ?>
		<h4>Lý do đơn hàng không thành công: </h4>
            <?php 
            	  if (!empty($model->content)) {
                            foreach ($model->content as $reason) {
                                echo '<p>- ' . $reason . '</p>';
                            }
                    }
            ?>
	<?php } ?>


</div>