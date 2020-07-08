
<a href="javascript:void(0)" class="btn btn-default btn-help"><i class="fa fa-align-justify"></i> Danh mục quản lý</a>
<div class="panel panel-default list-help">
    <ul class="list-group">
        <?php foreach ($model as $value) { ?>
            <li class="list-group-item"><a href="/help/index/<?= $value->_id ?>"><?= $value->title ?></a></li>
            <?php } ?>
    </ul>
</div>