<?php 
use common\components\Constant;

 ?>


<li id="item-" class="item <?= $model->status==0?'noactive':''?>">
	<div class="pull-left">
		<a data-id="<?= $model->id ?>" href="javascript:void(0)" class="read" data-href="<?= $model->url ?>">
			<p><?= $model->content ?></p>
			<p class="time"><i class="fas fa-clock"></i> <?= Constant::time($model->created_at) ?></p>
		</a>
	</div>
	<!-- <div class="pull-right">
		<a class="check-read" data-id="" title="asd" href="javascript:void(0)"><i class="fa fa-eye"></i></a>
	</div> -->
</li>

