<?php

use yii\widgets\ListView;
use frontend\widgets\FilterWidget;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$form = ActiveForm::begin([
            'id' => 'formSearch',
            'method' => 'get',
            'action' => '/filter'
        ]);
?>
<div class="container container-mobile">
    <div class="filter-mobi" id="filter-mobi">
        <div class="left">
            <!--<h3 class="cat-title"><a href="#">Giải trí & Thể thao</a></h3>-->
            <p><?= \Yii::t('common', 'Tìm thấy {0} sản phẩm',$dataProvider->getTotalCount()) ?></p>
        </div>
        <div class="right">
            <a href="#" class="button-filter"><?= \Yii::t('common', 'Bộ lọc') ?><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
        </div>
    </div>

    <div class="category-content">

        <div class="result">
            <h1 class="result-title"><?= \Yii::t('common', 'Tìm thấy {0} sản phẩm',$dataProvider->getTotalCount()) ?> </h1>
        </div>

        <div class="main-content">
            <div class="top-content">

                <div class="left">
                    <button type="button" class="button-filter"><svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="18" width="18" viewBox="0 0 18 18" style="vertical-align:middle"><g class="_3mz6y" fill="#333333"><rect x="0" y="3" width="18" height="2"></rect></g><g class="_1KOEm" fill="#333333"><rect x="0" y="8" width="18" height="2"></rect></g><g class="_1WxkA" fill="#333333"><rect x="0" y="13" width="18" height="2"></rect></g><g class="_3LPyO"><g><circle fill="#333333" cx="4.5" cy="4" r="2.2"></circle><circle fill="#FFFFFF" cx="4.5" cy="4" r="0.8"></circle></g></g><g class="_2tVMB"><g><circle fill="#333333" cx="13.5" cy="9" r="2.2"></circle><circle fill="#FFFFFF" cx="13.5" cy="9" r="0.8"></circle></g></g><g class="_3LAnt"><g><circle fill="#333333" cx="9" cy="14" r="2.2"></circle><circle fill="#FFFFFF" cx="9" cy="14" r="0.8"></circle></g></g></svg><span><?= \Yii::t('common', 'Lọc và tùy chỉnh') ?></span></button>
                </div>
                <div class="right">
                    <!--                    <div class="search-switch">
                                            <a href="javascript:void(0)" class="list <?= (!empty($_GET['show']) && ($_GET['show'] == "list")) ? "is-active" : "" ?>"><svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="1em" width="1em" viewBox="0 0 16 16" title="List" style="vertical-align:middle"><title>List</title>
                                                <g><path d="M0,3 L0,1 L2,1 L2,3 L0,3 Z M0,7 L0,5 L2,5 L2,7 L0,7 Z M0,11 L0,9 L2,9 L2,11 L0,11 Z M0,15 L0,13 L2,13 L2,15 L0,15 Z M4,3 L4,1 L16,1 L16,3 L4,3 Z M4,7 L4,5 L16,5 L16,7 L4,7 Z M4,11 L4,9 L16,9 L16,11 L4,11 Z M4,15 L4,13 L16,13 L16,15 L4,15 Z"></path></g></svg></a>
                                            <a href="javascript:void(0)" class="grid <?= ((!empty($_GET['show']) && ($_GET['show'] == "grid")) or empty($_GET['show'])) ? "is-active" : "" ?>"><svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="1em" width="1em" viewBox="0 0 16 16" title="Grid" style="vertical-align:middle"><title>Grid</title>
                                                <g><path d="M1,3.80447821 L1,1 L3.80447821,1 L3.80447821,3.80447821 L1,3.80447821 Z M6.5977609,3.80447821 L6.5977609,1 L9.4022391,1 L9.4022391,3.80447821 L6.5977609,3.80447821 Z M12.1955218,3.80447821 L12.1955218,1 L15,1 L15,3.80447821 L12.1955218,3.80447821 Z M1,9.4022391 L1,6.59706118 L3.80447821,6.59706118 L3.80447821,9.4022391 L1,9.4022391 Z M6.5977609,9.4022391 L6.5977609,6.5977609 L9.4022391,6.5977609 L9.4022391,9.4022391 L6.5977609,9.4022391 Z M12.1955218,9.4022391 L12.1955218,6.59706118 L15,6.59706118 L15,9.4022391 L12.1955218,9.4022391 Z M1,14.9993003 L1,12.1948221 L3.80447821,12.1948221 L3.80447821,14.9993003 L1,14.9993003 Z M6.5977609,14.9993003 L6.5977609,12.1948221 L9.4022391,12.1948221 L9.4022391,14.9993003 L6.5977609,14.9993003 Z M12.1955218,14.9993003 L12.1955218,12.1948221 L15,12.1948221 L15,14.9993003 L12.1955218,14.9993003 Z"></path></g></svg></a>
                                        </div>-->
                    <?php
                    if ((!empty($_GET['sell']) && $_GET['sell'] != 1) or empty($_GET['sell'])) {
                        ?>
                        <div class="search-date">
                            <input type="text" name="date" id="search-date" value="<?= !empty($_GET['date']) ? $_GET['date'] : '' ?>" placeholder="<?= \Yii::t('common', 'Tìm theo ngày') ?>">
                        </div>
                        <?php
                    }
                    ?>
                    <div class="sort">
                        <select id="sortby" name="sort">
                            <option value="new" <?= (!empty($_GET['sort']) && $_GET['sort'] == 'new') ? "selected" : "" ?>><?= \Yii::t('common', 'Mới nhất') ?></option>
                            <option value="price-asc" <?= (!empty($_GET['sort']) && $_GET['sort'] == 'price-asc') ? "selected" : "" ?>><?= \Yii::t('common', 'Giá thấp') ?></option>
                            <option value="price-desc" <?= (!empty($_GET['sort']) && $_GET['sort'] == 'price-desc') ? "selected" : "" ?>><?= \Yii::t('common', 'Giá cao') ?></option>
                        </select>
                        <i class="fa fa-angle-down"></i>
                    </div>
                </div>

            </div>
            <div class="content">
                <?= FilterWidget::widget() ?>
                <div id="content">
                    <?php
                    $show = (!empty($_GET['show']) && ($_GET['show'] == "list")) ? "list-product row list" : "list-product row gird";
                    ?>
                    <?=
                    ListView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'tag' => 'div',
                            'id' => 'list-wrapper'
                        ],
                        'itemOptions' => ['class' => 'col-sm-3 col-lg-3'],
                        'emptyText' => \Yii::t('common', 'Không có sản phẩm nào !'),
                        'layout' => "<div class='" . $show . "'>{items}</div>\n<div class='pagination-page text-center'>{pager}</div>",
                        'itemView' => '/product/_item',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="show" id="show" value="<?= (!empty($_GET['show']) && ($_GET['show'] == "list")) ? "list" : "gird" ?>">
<?php ActiveForm::end(); ?>
<?php
ob_start();
?>
<script type="text/javascript">

    $('#search-date').datepicker({
        dateFormat: 'dd/mm/yy',
        autoclose: true,
        startDate: new Date(),
        todayHighlight: true,
        changeMonth: true,
        changeYear: true,
        onSelect: function (data) {
            $("#formSearch").submit();
        }
    });
    $("body").on("change", "#search-date", function (event, state) {
        $("#formSearch").submit();
    });
    $("body").on("change", "#sortby", function (event, state) {
        $("#formSearch").submit();
    });
    //view-switch
    $('.search-switch .list').on('click', function () {
        $("#show").val('list');
        $("#formSearch").submit();
        return false;
    });
    $('.search-switch .grid').on('click', function () {
        $("#show").val('grid');
        $("#formSearch").submit();
        return false;
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
                
