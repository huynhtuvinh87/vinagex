<?php 
	$this->title = $model->title;
	$this->params['breadcrumbs'][] = $this->title;
 ?>
<div class="panel panel-default">
  <div class="panel-heading"><?= $model->title ?></div>
  <div class="panel-body"><?= $model->content ?></div>
</div>