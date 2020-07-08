<?php 
use common\components\Constant;
 ?>
<li id="item-<?= $model->id ?>" class="item <?= $model->status == 0?'noactive':'active'?>">
	
	<div class="pull-left">
		<a data-id="<?= $model->id ?>" href="javascript:void(0)" class="read" data-href="<?= $model->url ?>">
		<p><?= $model->content ?></p>
		<p class="time"><i class="fas fa-clock"></i> <?= Constant::time($model->created_at) ?></p>
		</a>
	</div>
	<div class="pull-right">
		<a class="check-read" data-id="<?= $model->id ?>" title="<?= $model->status == 0?'Đánh dấu đã đọc':'Đánh dấu chưa đọc' ?>" href="javascript:void(0)"><i class="fa fa-eye"></i></a>
	</div>
</li>


