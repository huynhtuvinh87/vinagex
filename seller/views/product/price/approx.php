<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$i = 0;
?>
<div id="approx">
    <?=
    $form->field($model, 'error_approx', [
        'template' => '<div class="col-sm-12 error">{error}</div>',
    ])->textInput(['type' => 'hidden'])
    ?>
    <div id="approx-list">

        <?php
        $i = 0;
        if ($model->approx) {
            foreach ($model->approx as $key => $value) {

                if ((int) $value['quantity_min'] <= $model['quantity_stock']) {
                    $i += 1;
                    ?>
                    <div class="row form-group">
                        <div class="col-sm-11 col-xs-12">
                            <div class="input-group-row">
                                <div class="input-group">
                                    <span class="input-group-addon">SL từ</span><input id="approx_quantity_min_<?= $key ?>" class="form-control" type="number" name="approx_quantity_min[]" value="<?= $value['quantity_min'] ?>" data-key="<?= $key ?>" data-type="quantity_min">
                                </div>

                                <div class="input-group">
                                    <span class="input-group-addon">đến</span><input id="approx_quantity_max_<?= $key ?>" class="form-control <?= !$value['quantity_max'] ? "required" : "" ?>" onkeypress = "return isNumber(event)" name="approx_quantity_max[]" value="<?= ((int) $value['quantity_min'] <= $model['quantity_stock'] && $model['quantity_stock'] <= (int) $value['quantity_max']) ? $model['quantity_stock'] : $value['quantity_max'] ?>" data-key="<?= $key ?>" data-type="quantity_max">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">có giá</span><input type="number" id="approx_price_<?= $key ?>" class="form-control <?= !$value['price'] ? "required" : "" ?> price" name="approx_price[]" value="<?= $value['price'] ?>"  data-key="<?= $key ?>" data-type="price">
                                </div>
                            </div>
                        </div>
                        <?php if ($i != 1) { ?>
                            <div class="col-sm-1 col-xs-2"><a href="javascript:void(0)" class="approx-delete" data-id="<?= $key ?>" style="color:red; font-size:12px">Xoá</a></div>
                        <?php } ?>
                    </div>
                    <?php
                }
            }
            if ($i == 0) {
                ?>
                <input type="hidden" value="1" name="approx_quantity_min[]">
                <input type="hidden" value="2" name="approx_quantity_max[]">
                <input type="hidden" value="2" name="approx_price[]">       
                <?php
            }
        } else {
            $i = 1;
            ?>
            <div class="row form-group">
                <div class="col-sm-11 col-xs-12">
                    <div class="input-group-row">
                        <div class="input-group"><span class="input-group-addon">SL từ</span><input id="approx_quantity_min_0" class="form-control" onkeypress = "return isNumber(event)" name="approx_quantity_min[]" value="1"  data-key="0" data-type="quantity_min"></div>

                        <div class="input-group"><span class="input-group-addon">đến</span><input id="approx_quantity_max_0" class="form-control" onkeypress = "return isNumber(event)" name="approx_quantity_max[]" value="20"  data-key="0" data-type="quantity_max"></div>

                        <div class="input-group"><span class="input-group-addon">có giá</span><input type="number" id="approx_price_0" class="form-control price" name="approx_price[]"  data-key="0" data-type="price"></div>
                    </div>

                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <?php if ($i != 0) { ?>
        <a href="javascript:void(0)" id="approx-add" class="approx-add" style="color:#5cb85c" data-num="<?= $i ?>">Thêm khung giá</a>
    <?php } ?>



</div>
<?php ob_start(); ?>
<script type="text/javascript">
    function toNumber(str) {
        return parseInt(str);
    }
    function getApprox(id, min, readonly = '') {
        var max = min + 9;
        var html = '<div class="row form-group">';
        html += '<div class="col-sm-11 col-xs-12"><div class="input-group-row"><div class="input-group"><span class="input-group-addon">SL từ</span><input id="approx_quantity_min_' + id + '" class="form-control" onkeypress = "return isNumber(event)" name="approx_quantity_min[]" value="' + min + '" data-key="' + id + '" data-type="quantity_min"></div>';
        html += '<div class="input-group"><span class="input-group-addon">đến</span><input id="approx_quantity_max_' + id + '" class="form-control" name="approx_quantity_max[]" onkeypress = "return isNumber(event)" value="' + max + '" data-key="' + id + '" data-type="quantity_max"></div>';
        html += '<div class="input-group"><span class="input-group-addon">có giá</span><input type="number" id="approx_price_' + id + '" class="form-control price" name="approx_price[]" data-key="' + id + '" data-type="price"></div></div></div>';
        html += '<div class="col-sm-1 col-xs-2"><a href="javascript:void(0)" class="approx-delete" data-id="' + id + '" style="color:#5cb85c; font-size:12px">Xoá</a></div>';
        html += '</div>';
        return html;
    }
    $("body").on("change", "#approx-list input", function (event, state) {
        $(".error .help-block-error").html('');
        var key = parseInt($(this).attr('data-key'));
        var type = $(this).attr('data-type');
        var val = toNumber($(this).val());
        var num = parseInt($("#approx-add").attr("data-num"));
        if (key > 0) {
            var prev = key - 1;
            var prev_val_max = toNumber($("#approx_quantity_max_" + prev).val());
            if (val <= prev_val_max) {
                $("#approx_quantity_min_" + key).val(parseInt(prev_val_max + 1));
            }
            if (val >= prev_val_max + 2) {
                $("#approx_quantity_min_" + key).val(parseInt(prev_val_max + 1));
            }
        }
        if (type == "quantity_max") {
            var j = parseInt(key + 1);

            $("#approx_quantity_min_" + j).val(parseInt($(this).val()) + 1);
            for (i = j; i < num; i++) {
                $("#approx_quantity_min_" + i).val("");
                $("#approx_quantity_max_" + i).val("");
                $("#approx_price_" + i).val("");
            }
        }
    });
    $("body").on("click", ".approx-create", function (event, state) {
        $(this).attr("data-num", 1);
        $("#classify-group").hide();
        $("#approx").show();
        $("#price-quantity").hide();
        $("#approx-list").append(getApprox(0, 1));
        $("#productform-price").attr("disabled", "disabled");
        $("#productform-quantity").attr("disabled", "disabled");
    });
    $("body").on("click", ".approx-add", function (event, state) {
        var id = parseInt($(this).attr("data-num"));
        var num = parseInt(id + 1);
        if (num == 4) {
            $(this).hide();
        }
        if (num <= 4) {
            $(this).attr("data-num", num);
            var qtt_max = $("input[name^='approx_quantity_max']");
            var max = [];
            for (var i = 0; i < qtt_max.length; i++) {
                if (qtt_max[i].value != "") {
                    max.push(toNumber(qtt_max[i].value));
                }
            }
            if (typeof max[qtt_max.length - 1] == "undefined") {
                var quantity_min = 1;
            } else {
                var quantity_min = toNumber(max[qtt_max.length - 1]) + 1;
            }
            $("#approx-list").append(getApprox(id, quantity_min, 'readonly'));
        }
    });
    $("body").on("click", ".approx-delete", function (event, state) {
        var num = parseInt(parseInt($('#approx-add').attr("data-num")) - 1);
        $('#approx-add').attr("data-num", num);
        $('#approx-add').show();
        $(this).parent().parent().remove();
        if ($("#approx-list").children().length == 0) {
            $("#approx").hide();
            $("#price-quantity").show();
            $("#productform-price").removeAttr("disabled");
            $("#productform-quantity").removeAttr("disabled");
        }
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>