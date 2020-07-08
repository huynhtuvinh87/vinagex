<?php

use yii\widgets\Pjax;
use yii\grid\GridView;

function search($category) {
    switch ($category) {
        case 1:
            return Yii::t('company', 'Nhà vườm tiêu chuẩn Việt Gap');
            break;
        case 2:
            return Yii::t('company', 'Dịch vụ nông nghiệm');
            break;
        case 3:
            return Yii::t('company', 'Sản xuất và cung cấp nông sản');
            break;
        case 4:
            return Yii::t('company', 'Tư vấn nông nghiệp');
            break;
    }
}
?>
<form action="/" method="get" id="formSearch">
    <div class="banner-search">
        <div class="container">
            <h2><?= $this->title ?></h2>
            <div class="company-search">
                <div class="input-group">
                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span id="search_concept"><?= !empty($_GET['category']) ? search($_GET['category']) : Yii::t('company', 'Chọn danh mục') ?></span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#1"><?= Yii::t('company', 'Nhà vườm tiêu chuẩn Việt Gap') ?></a></li>
                            <li><a href="#2"><?= Yii::t('company', 'Dịch vụ nông nghiệm') ?></a></li>
                            <li><a href="#3"><?= Yii::t('company', 'Sản xuất và cung cấp nông sản') ?></a></li>
                            <li><a href="#4"><?= Yii::t('company', 'Tư vấn nông nghiệp') ?></a></li>
                        </ul>
                    </div>
                    <input type="hidden" name="category" value="<?= !empty($_GET['category']) ? $_GET['category'] : "" ?>" id="search_param">         
                    <input type="text" class="form-control" name="keyword" placeholder="<?= Yii::t('company', 'Tìm kiếm bằng tên công ty, địa chỉ...') ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </div>
        </div>
    </div>

</form>
<div class="container">
    <h2><?= Yii::t('company', 'Danh bạ công ty') ?></h2>
    <?php Pjax::begin(['id' => 'pjax-grid-company']); ?>  
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}",
        'emptyText' => 'Không có công ty nào',
        'tableOptions' => ['class' => 'table table-bordered table_responsive'],
        'columns' => [
            [
                'attribute' => 'Tên công ty',
                'format' => 'raw',
                'value' => function($data) {
                    return data('Ngày đi', $data['name']);
                },
            ],
            [
                'attribute' => 'Địa chỉ',
                'format' => 'raw',
                'value' => function($data) {
                    return data('Địa chỉ', $data['address']);
                },
            ],
            [
                'attribute' => 'Sản phẩm',
                'format' => 'raw',
                'value' => function($data) {
                    return data('Sản phẩm', $data['product']);
                },
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
<?php

function data($title, $content) {
    $html = '<div class="left">';
    $html .= '<strong>' . $title . ': </strong>';
    $html .= '</div>';
    $html .= '<div class="right">';
    $html .= $content;
    $html .= '</div>';
    $html .= '<div style="clear: both;"></div>';
    return $html;
}
?>