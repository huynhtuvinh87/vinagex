<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\ActiveForm;
?>

<div id="sidebar">
    <div class="sidebar-inner">
        <div class="header-mobi">
            <a href="#" class="btn back"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?= \Yii::t('common', 'Quay lại') ?></a>
            <?= \Yii::t('common', 'Bộ lọc') ?>
        </div>
        <div class="product-filters">
            <div class="widget">
                <div class="widget-title">
                    <h4><?= \Yii::t('common', 'Danh mục') ?></h4>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </div>

                <div class="list-radio filter-category">
                    <?php
                    foreach ($model->category() as $key => $value) {
                        ?>
                        <div class="item">
                            <label class="radio">
                                <input type="radio" id="filter-category_<?= $value['id'] ?>" name="category" value="<?= $value['id'] ?>" <?= (!empty($_GET['category']) && $_GET['category'] == $value['id']) ? "checked" : "" ?> style="display: none">
                                <span><?= Yii::t('data', 'category_' . $value['id']) ?></span>
                            </label>
                            <span><?= $value['count'] ?></span>

                            <div class="list-checkbox" style="display: <?= (!empty($_GET['category']) && $_GET['category'] == $value['id']) ? "block" : "none" ?>; padding: 10px 0">
                                <div class="scrollbar-inner">
                                    <?php
                                    foreach ($value['parent'] as $type) {
                                        ?>
                                        <div class="item">
                                            <label class="checkbox-square">
                                                <input type="checkbox"  id="filter-type_<?= $type['id'] ?>" name="type[]" <?= (!empty($_GET['type']) && $type['id'] == $_GET['type']) ? "checked" : "" ?> value="<?= $type['id'] ?>">
                                                <span><?= Yii::t('data', 'sub_category_' . $type['id']) ?></span>
                                            </label>
                                            <span><?= $type['count'] ?></span>

                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>





            <div class="widget">
                <div class="widget-title">
                    <h4><?= \Yii::t('common', 'Giá') ?></h4>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </div>
                <div class="price">
                    <label>
                        <input type="number" name="from_price" id="filter-from_price" value="<?= !empty($_GET['from_price']) ? $_GET['from_price'] : '' ?>" placeholder="<?= \Yii::t('common', 'Giá từ') ?>">
                    </label>
                    <span>-</span>
                    <label>
                        <input type="number" name="to_price" id="filter-to_price" value="<?= !empty($_GET['to_price']) ? $_GET['to_price'] : '' ?>"  placeholder="<?= \Yii::t('common', 'đến') ?>">
                    </label>
                    <button><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    <h4><?= \Yii::t('common', 'Số lượng') ?> <small>(kg)</small></h4>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </div>
                <div class="price">
                    <label>
                        <input type="number" name="quantity_min" id="filter-quantity_min" value="<?= !empty($_GET['quantity_min']) ? $_GET['quantity_min'] : '' ?>" placeholder="<?= \Yii::t('common', 'Số lượng từ') ?>">
                    </label>
                    <span>-</span>
                    <label>
                        <input type="number" name="quantity_max" id="filter-quantity_max" value="<?= !empty($_GET['quantity_min']) ? $_GET['quantity_min'] : '' ?>"  placeholder="<?= \Yii::t('common', 'đến') ?>">
                    </label>
                    <button><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    <h4><?= \Yii::t('common', 'Theo tiêu chí') ?></h4>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </div>
                <div class="list-radio">
                    <?php
                    foreach ($model->sell() as $key => $value) {
                        ?>
                        <div class="item">
                            <label class="radio">
                                <input type="radio" id="filter-sell_<?= $key ?>" <?= (!empty($_GET['sell']) && $key == $_GET['sell']) ? "checked" : "" ?> name="sell" value="<?= $key ?>">
                                <span><?= $value ?></span>
                            </label>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    <h4><?= \Yii::t('common', 'Theo tiêu chuẩn') ?></h4>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </div>
                <div class="list-checkbox">
                    <?php
                    foreach ($model->certification() as $key => $value) {
                        ?>
                        <div class="item">
                            <label class="checkbox-square">
                                <input type="checkbox"  id="filter-certification_<?= $value['id'] ?>" <?= (!empty($_GET['certification']) && in_array($value['id'], $_GET['certification'])) ? "checked" : "" ?> name="certification[]" value="<?= $value['id'] ?>">
                                <span><?= Yii::t('data', 'certification_' . $value['id']) ?></span>
                            </label>
                            <span><?= $value['count'] ?></span>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    <h4><?= \Yii::t('common', 'Theo loại') ?></h4>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </div>
                <div class="list-radio">
                    <?php
                    foreach ($model->classify() as $key => $value) {
                        ?>
                        <div class="item">
                            <label class="radio">
                                <input type="radio" id="filter-classify_<?= $key ?>" <?= (!empty($_GET['classify']) && $key == $_GET['classify']) ? "checked" : "" ?> name="classify" value="<?= $key ?>">
                                <span><?= $value ?></span>
                            </label>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <div class="nav-bottom"><button type="submit" class="btn btn-success btn-apply"><?= Yii::t('common', 'Áp dụng')?></button><button type="button" class="btn btn-default btn-reset"><?= Yii::t('common', 'Xóa')?></button></div>
    </div>
</div>

<input type="hidden" name="keywords" id="filter-keywords" value="<?= !empty($_GET['keywords']) ? $_GET['keywords'] : '' ?>">

<?php ob_start(); ?>
<script type="text/javascript">

    $(document).ready(function () {
        if ($(window).width() >= 1024) {
            $("#formSearch").on("change", "input:checkbox, input:radio", function () {
                $("#formSearch").submit();
            });
        } else {
            $("#formSearch .filter-category").on("change", "input:radio", function () {
                $(".list-checkbox").hide();
                $(this).parent().parent().find(".list-checkbox").show();
            });
        }
        $("body").on('click', '.btn-reset', function () {
            $('#formSearch input:checkbox').removeAttr('checked');
            $('#formSearch input:checkbox').prop('checked', false);
            $('#formSearch input:radio').prop('checked', false);
            $('#formSearch input:text').val("");
            $('#formSearch input[type=number]').val("");
            return false;
        });

//        $(".filter-category").on("change", "input:radio", function () {
//            $.get("/ajax/parent/" + $(this).val(), function (data) {
//                $("#widget-parent").html(data);
//            });
//        });
        var filter_selected = '';
        if (typeof $("input[name='category']:checked").val() != "undefined") {
            var category = $("input[name='category']:checked");
            category.parent().addClass("active");
            $('.list-search button span').html(category.next('span').html());
            filter_selected += selected(category.next('span').html(), category.attr('id'));
        }
        $("input[name='type[]']:checked").each(function ()
        {
            filter_selected += selected($(this).next('span').html(), $(this).attr('id'));
        });
        if ($("input[name='from_price']").val() != "") {
            filter_selected += selected($("input[name='from_price']").val(), $("input[name='from_price']").attr('id'));
        }
        if ($("input[name='to_price']").val() != "") {
            filter_selected += selected($("input[name='to_price']").val(), $("input[name='to_price']").attr('id'));
        }
        if ($("input[name='quantity_min']").val() != "") {
            filter_selected += selected($("input[name='quantity_min']").val(), $("input[name='quantity_min']").attr('id'));
        }
        if ($("input[name='quantity_max']").val() != "") {
            filter_selected += selected($("input[name='quantity_max']").val(), $("input[name='quantity_max']").attr('id'));
        }
        if ($("input[name='date']").val() != "") {
            filter_selected += selected($("input[name='date']").val(), $("input[name='date']").attr('id'));
        }
        if (typeof $("input[name='sell']:checked").val() != "undefined") {
            var sell = $("input[name='sell']:checked");
            filter_selected += selected(sell.next('span').html(), sell.attr('id'));
        }
        $("input[name='certification[]']:checked").each(function ()
        {
            filter_selected += selected($(this).next('span').html(), $(this).attr('id'));
        });
        if (typeof $("input[name='classify']:checked").val() != "undefined") {
            var classify = $("input[name='classify']:checked");
            filter_selected += selected(classify.next('span').html(), classify.attr('id'));
        }
        if ($("input[name='keywords']").val() != "") {
            filter_selected += selected($("input[name='keywords']").val(), $("input[name='keywords']").attr('id'));
        }
        $("#filter_selected").html(filter_selected);
        $('.filter-remove').on('click', function () {
            var id = $(this).attr('data-id');
            $("#" + id).val("");
            $("#" + id).prop('checked', false);
            $("#formSearch").submit();
            return false;
        });

    });
    function selected(title, id) {
        return '<div class="btn-group"> <button type="button" class="btn btn-default">' + title + '</button> <button type="button" data-id="' + id + '" class="btn btn-default filter-remove"> <i class="close"></i></button></div>';
    }
    // scroll bar
    $('.scrollbar-inner').scrollbar();

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
