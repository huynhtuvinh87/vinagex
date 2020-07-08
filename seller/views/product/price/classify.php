<?php
use common\components\Constant;
?>
<div id="classify">
    <?=
    $form->field($model, 'error_classify', [
        'template' => '<div class="col-sm-12 error">{error}</div>',
    ])->textInput(['type' => 'hidden'])
    ?>
    <?php
    if ($model->classify) {
        foreach ($model->classify as $k => $value) {
            ?>
            <div id="classify-<?= $k ?>">
                <div class="row">
                    <div class=" col-sm-11">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-3 col-xs-12"><input type="text" class="form-control" name="classify_kind[<?= $k ?>]" required="" value="<?= $value['kind'] ?>"></div>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class="row">
                                            <div class="col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" name="classify_description[<?= $k ?>]" value="<?= $value['description'] ?>"  placeholder="Thêm mô tả cho loại này">
                                            </div>
                                            <div class="classify_price_quantity col-sm-12 col-xs-12" style=";display: <?= !empty($value['frame']) ? "none" : "block" ?>">

                                                <div class="input-group-row">
                                                    <div class="input-group"><span class="input-group-addon">SL tối thiểu</span>
                                                        <input type="number" id="classify_quantity-min-<?= $k ?>" class="form-control <?= $value['quantity_min'] == "" ? "required" : "" ?>" name="classify_quantity_min[<?= $k ?>]" value="<?= $value['quantity_min'] ?>">
                                                    </div>
                                                    <div class="input-group"><span class="input-group-addon">Giá</span>
                                                        <input type="number" id="classify_price-<?= $k ?>" class="form-control price <?= $value['price_min'] == "" ? "required" : "" ?>" name="classify_price[<?= $k ?>]" required="" value="<?= $value['price_min'] ?>">
                                                    </div>
                                                    <div class="input-group"><span class="input-group-addon">SL kho</span>
                                                        <input type="number" id="classify_quantity-stock-<?= $k ?>" class="form-control <?= $value['quantity_stock'] == "" ? "required" : "" ?>" name="classify_quantity_stock[<?= $k ?>]" required="" value="<?= $value['quantity_stock'] ?>">
                                                    </div>
                                                </div>
                                                <div style="padding-top:10px; clear: both">
                                                    <a href="javascript:void(0)" class="frame-add create" style="color:#5cb85c; font-size: 12px; display: <?= !empty($value['frame']) ? "none" : "block" ?>" data-num="1" data-key="<?= $k ?>">Tạo khoảng giá</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="frame col-sm-12" style="margin-top: 10px; display: <?= !empty($value['frame']) ? "block" : "none" ?>">
                                        <div class="row">
                                            <div class="col-sm-3 col-xs-12">Khoảng giá <br><small>(Số lượng từ, số lượng đến và giá)</small></div>
                                            <div class="col-sm-9 col-xs-12">
                                                <div id="classify-frame-<?= $k ?>">
                                                    <?php
                                                    $num = 0;
                                                    if (!empty($value['frame'])) {
                                                        foreach ($value['frame'] as $f => $val) {
                                                            if ((int) $val['quantity_min'] <= $value['quantity_stock']) {
                                                                $num++;
                                                                ?>
                                                                <div class="row form-group">
                                                                    <div class="col-sm-11 col-xs-12">
                                                                        <div class="input-group-row">
                                                                            <div class="input-group"><span class="input-group-addon">SL từ</span><input type="number" id="quantity_min_<?= $k ?>_<?= $f ?>" class="form-control" name="quantity_min[<?= $k ?>][]" value="<?= $val['quantity_min'] ?>" data-id="<?= $k ?>" data-key="<?= $f ?>" data-type="quantity_min"></div>
                                                                            <div class="input-group"><span class="input-group-addon">đến</span>
                                                                                <?php
                                                                                if (($val['quantity_min'] <= $value['quantity_stock']) && ($val['quantity_max'] >= $value['quantity_stock'])) {
                                                                                    ?>
                                                                                    <input type="number" id="quantity_max_<?= $k ?>_<?= $f ?>" class="form-control <?= !$val['quantity_max'] ? "required" : "" ?>" name="quantity_max[<?= $k ?>][]" value="<?= $value['quantity_stock'] ?>" data-id="<?= $k ?>" data-key="<?= $f ?>" data-type="quantity_max">
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <input type="number" id="quantity_max_<?= $k ?>_<?= $f ?>" class="form-control <?= !$val['quantity_max'] ? "required" : "" ?>" name="quantity_max[<?= $k ?>][]" value="<?= $val['quantity_max'] ?>" data-id="<?= $k ?>" data-key="<?= $f ?>" data-type="quantity_max">
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                            <div class="input-group"><span class="input-group-addon">có giá</span><input type="number" id="price_<?= $k ?>_<?= $f ?>" class="form-control price <?= !$val['price'] ? "required" : "" ?>" name="frame_price[<?= $k ?>][]" value="<?= $val['price'] ?>" data-id="<?= $k ?>" data-key="<?= $f ?>" data-type="price"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-1 col-xs-12"><a href="javascript:void(0)" class="frame_delete" data-id="<?= $k ?>" style="color:#5cb85c; font-size:12px">Xoá</a></div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <a href="javascript:void(0)" id="classify-frame-add-<?= $k ?>" class="frame-add" style="color:#5cb85c; font-size:12px" data-num="<?= $num ?>" data-key="<?= $k ?>">Thêm khoản giá</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1"><a href="javascript:void(0)" class="classify_delete" style="color:#5cb85c; font-size:12px">Xoá</a></div>
                </div>
            </div>
            <?php
        }
    } else {
        $k = 0;
        ?>
        <div id="classify-0">
            <div class="row">
                <div class=" col-sm-11">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <input type="text" class="form-control" name="classify_kind[]" required="" value="Loại 1">
                                </div>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <input type="text" class="form-control" name="classify_description[0]" placeholder="Thêm mô tả cho loại này">
                                        </div>
                                        <div class="classify_price_quantity col-sm-12 col-xs-12">
                                            <div class="input-group-row">
                                                <div class="input-group">
                                                    <span class="input-group-addon">SL tối thiểu</span>
                                                    <input type="number" id="classify_quantity-min-0" class="form-control" name="classify_quantity_min[0]">
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">Giá</span>
                                                    <input type="number" id="classify_price-0" class="form-control price" name="classify_price[0]">
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">SL kho</span>
                                                    <input type="number" id="classify_quantity_stock-0" class="form-control" name="classify_quantity_stock[0]">
                                                </div>
                                            </div>
                                            <div style=" margin-top: 20px; clear: both">
                                                <a href="javascript:void(0)" class="frame-add create" style="color: rgb(92, 184, 92); font-size: 12px;" data-num="0" data-key="0">Tạo khoảng giá</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frame col-sm-12" style="margin-top: 10px; display: none">          
                                    <div class="row">               
                                        <div class="col-sm-3 col-xs-12">   
                                            Khoảng giá <br><small>(Số lượng từ, số lượng đến và giá)</small>               
                                        </div>          
                                        <div class="col-sm-9 col-xs-12">               
                                            <div id="classify-frame-0">
                                            </div>              
                                            <div class="row">                   
                                                <div class="col-sm-12">            
                                                    <a href="javascript:void(0)" id="classify-frame-add-0" class="frame-add" style="color:#5cb85c; font-size:12px" data-num="1" data-key="0">Thêm khoản giá</a>                 
                                                </div>                 
                                            </div>          
                                        </div>          
                                    </div>          
                                </div>
                            </div>   
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


</div>
<a href="javascript:void(0)" class="classify-add" id="classify-add" style="color:#5cb85c" data-num="<?= count($model->classify) > 0 ? count($model->classify) : 1 ?>">Thêm phân loại hàng</a>
<?php ob_start(); ?>
<script type="text/javascript">

    function getClassify(id) {
        var kind = parseInt(id) + 1;
        var html = '<div id="classify-' + id + '"><div class="row"><div class=" col-sm-11"><div class="panel panel-default"><div class="panel-body"><div class="row">';
        html += '<div class="col-sm-3 col-xs-12"><input type="text" class="form-control" name="classify_kind[]" required="" value="Loại ' + kind + '"></div>';
        html += '<div class="col-sm-9 col-xs-12">';
        html += '<div class="row">';
        html += '<div class="col-sm-12 col-xs-12"><input type="text" class="form-control" name="classify_description[' + id + ']" placeholder="Thêm mô tả cho loại này"></div>';

        html += '<div class="classify_price_quantity col-sm-12 col-xs-12">';
        html += '<div class="input-group-row"><div class="input-group"><span class="input-group-addon">SL tối thiểu</span><input type="number" id="classify_quantity-min' + id + '" class="form-control" name="classify_quantity_min[' + id + ']"></div>';
        html += '<div class="input-group"><span class="input-group-addon">Giá</span><input type="number" id="classify_price-' + id + '" class="form-control price" name="classify_price[' + id + ']"></div>';
        html += '<div class="input-group"><span class="input-group-addon">SL kho</span><input type="number" class="form-control" name="classify_quantity_stock[' + id + ']"></div></div>';
        html += '<div style="padding-top:10px; clear: both"><a href="javascript:void(0)" class="frame-add create" style="color:#5cb85c; font-size: 12px" data-num="0" data-key="' + id + '">Tạo khoảng giá</a>';
        html += '</div></div></div>';
        html += '<div class="frame col-sm-12" style="margin-top: 10px; display: none">';
        html += '                  <div class="row">';
        html += '                    <div class="col-sm-3 col-xs-12">';
        html += '                         Khoảng giá <br><small>(Số lượng từ, số lượng đến và giá)</small>';
        html += '                     </div>';
        html += '                    <div class="col-sm-9 col-xs-12">';
        html += '                        <div id="classify-frame-' + id + '">';
        html += '                       </div>';
        html += '                       <div class="row">';
        html += '                           <div class="col-sm-12">';
        html += '                             <a href="javascript:void(0)" id="classify-frame-add-' + id + '" class="frame-add" style="color:#5cb85c; font-size:12px" data-num="1" data-key="' + id + '">Thêm khoản giá</a>';
        html += '                          </div>';
        html += '                      </div>';
        html += '                  </div>';
        html += '               </div>';
        html += '           </div></div>';
        html += '     </div>';
        html += '  </div>';
        html += '</div></div>';
        html += '<div class="col-sm-1"><a href="javascript:void(0)" class="classify_delete" style="color:#5cb85c; font-size:12px">Xoá</a></div></div>';
        return html;
    }
    function getFrame(id, min, key) {
        $("#classify-" + id + " .create").hide();
        $("#classify-" + id + " .classify_price_quantity").hide();
        $("#classify-" + id + " .classify_description").show();
        $("#classify_price-" + id).attr('disabled', 'disabled');
        $("#classify_quantity-" + id).attr('disabled', 'disabled');
        var max = min + 9;
        var html = '<div class="row form-group">';
        html += '<div class="col-sm-11 col-xs-12"><div class="input-group-row"><div class="input-group"><span class="input-group-addon">SL từ</span><input type="number" id="quantity_min_' + id + '_' + key + '" class="form-control" name="quantity_min[' + id + '][]"  value="' + min + '" data-id="' + id + '" data-key="' + key + '" data-type="quantity_min"></div>';
        html += '<div class="input-group"><span class="input-group-addon">đến</span><input  id="quantity_max_' + id + '_' + key + '" class="form-control price" name="quantity_max[' + id + '][]" value="' + max + '" data-id="' + id + '" data-key="' + key + '" data-type="quantity_max"></div>';
        html += '<div class="input-group"><span class="input-group-addon">có giá</span><input type="number" id="price_' + id + '_' + key + '" class="form-control price" name="frame_price[' + id + '][]" data-id="' + id + '" data-key="' + key + '" data-type="price"></div></div></div>';
        html += '<div class="col-sm-1 col-xs-12"><a href="javascript:void(0)" class="frame_delete" data-id="' + id + '" style="color:#5cb85c; font-size:12px">Xoá</a></div>';
        html += '</div>';
        return html;
    }


    $("body").on("click", ".classify-add", function (event, state) {
        var id = parseInt($(this).attr("data-num"));
        var num = parseInt(id + 1);
        if (num == 4) {
            $(this).hide();
        }
        if (num <= 4) {
            $(this).attr("data-num", num);
            $("#classify").append(getClassify(id));
        }
    });

    $("body").on("click", ".classify-create", function (event, state) {
        $(this).attr("data-num", 1);
        $("#classify-group").show();
        $("#price-quantity").hide();
        $("#classify").append(getClassify(0));
        $(".classify-add").attr("data-num", 1);
        $("#productform-price").val("");
        $("#productform-quantity").val("");
        $("#productform-price").attr("disabled", "disabled");
        $("#productform-quantity").attr("disabled", "disabled");
    });
    $("body").on("click", ".classify_delete", function (event, state) {
        var num = parseInt(parseInt($('#classify-add').attr("data-num")) - 1);
        $('#classify-add').attr("data-num", num);
        $('#classify-add').show();
        $(this).parent().parent().parent().remove();
        if ($("#classify").children().length == 0) {
            $("#classify-group").hide();
            $("#price-quantity").show();
            $("#productform-price").removeAttr("disabled");
            $("#productform-quantity").removeAttr("disabled");
        }
    });
    $("body").on("click", ".frame-add", function (event, state) {
        var id = parseInt($(this).attr("data-key"));
        var key = parseInt(parseInt($(this).attr("data-num")));
        console.log(key);
        if (key == 3) {
            $(this).hide();
        }

        $("#classify-frame-add-" + id).attr("data-num", parseInt(key + 1));
        $("#classify-" + id + " .frame").show();
        var qtt_max = $("input[name^='quantity_max[" + id + "]']");
        var max = [];
        for (var i = 0; i < qtt_max.length; i++) {
            if (qtt_max[i].value != "") {
                max.push(parseInt(qtt_max[i].value));
            }
        }
        if (typeof max[qtt_max.length - 1] == "undefined") {
            var quantity_min = 1;
        } else {
            var quantity_min = parseInt(max[qtt_max.length - 1]) + 1;
        }
        console.log(id, quantity_min, key);
        $("#classify-frame-" + id).append(getFrame(id, quantity_min, key));

    });
    $("body").on("click", ".frame_delete", function (event, state) {
        var id = $(this).attr("data-id");
        var num = parseInt(parseInt($('#classify-frame-add-' + id).attr("data-num")) - 1);
        $('#classify-frame-add-' + id).attr("data-num", num);
        $('#classify-frame-add-' + id).show();
        $(this).parent().parent().remove();

        if ($("#classify-frame-" + id).children().length == 0) {
            $("#classify-" + id + " .frame").hide();
            $("#classify-" + id + " .create").show();
            $("#classify_price-" + id).removeAttr("disabled");
            $("#classify_quantity-" + id).removeAttr("disabled");
            $("#classify-" + id + " .classify_price_quantity").show();
            $("#classify-" + id + " .classify_description").hide();

        }
    });

    $("body").on("change", "#classify input", function (event, state) {
        var id = parseInt($(this).attr('data-id'));
        var key = parseInt($(this).attr('data-key'));
        var type = $(this).attr('data-type');
        var val = parseInt($(this).val());
        var num = parseInt($("#classify-frame-add-" + id).attr("data-num"));
        if (key > 0) {
            var prev = key - 1;
            var prev_val_max = parseInt($("#quantity_max_" + id + '_' + prev).val());
            if (val <= prev_val_max) {
                $("#quantity_min_" + id + '_' + key).val(parseInt(prev_val_max + 1));
            }
            if (val >= prev_val_max + 2) {
                $("#quantity_min_" + id + '_' + key).val(parseInt(prev_val_max + 1));
            }
        }
        if (type == "quantity_max") {
            var j = parseInt(key + 1);
            $("#classify_quantity-min-" + j).val(parseInt($(this).val()) + 1);
            for (i = j; i < num; i++) {
                $("#quantity_min_" + id + '_' + i).val("");
                $("#quantity_max_" + id + '_' + i).val("");
                $("#price_" + id + '_' + i).val("");
            }
        }

    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>