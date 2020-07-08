<?php

$this->title = Yii::t('data', 'page_title_'.$model->_id);
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Yii::t('data', 'page_content_'.$model->_id) ?>
