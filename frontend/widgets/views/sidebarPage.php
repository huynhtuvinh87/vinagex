<ul id="tree" class="tree">
    <?php
    foreach ($page->widget() as $k => $value) {
        if ($k != $page::WIDGET_TUTORIAL && $k != $page::WIDGET_ADDRESS) {
            ?>
            <li class="branch"><a href="javascript:void(0)"><?= $value ?></a>
                <ul>
                    <?php
                    foreach ($model as $value) {
                        if ($value->widget == $k) {
                            ?>
                            <li class="<?= (!empty($_GET['slug']) && Yii::$app->request->get('slug') == $value->slug) ? 'active' : '' ?>">

                                <a href="/p/<?= $value->slug ?>"><?= Yii::t('data', 'page_title_'.$value->_id) ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }
    ?>
</ul>

<?php ob_start(); ?>
<script>
    $.fn.extend({
        treed: function () {

            var openedClass = 'glyphicon glyphicon-minus';
            var closedClass = 'glyphicon glyphicon-plus';
            //initialize each of the top levels
            var tree = $(this);
            tree.addClass("tree");
            tree.find('li').has("ul").each(function () {
                var branch = $(this); //li with children ul
                if (branch.find('ul').find('li').hasClass('active')) {
                    branch.prepend("<i class='indicator glyphicon" + openedClass + "'></i>");
                } else {
                    branch.prepend("<i class='indicator glyphicon" + closedClass + "'></i>");
                }

                branch.on('click', function (e) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    branch.find('ul').toggle();
                });


            });
        }
    });

    $('#tree').treed();

    $('li.active').parent().css('display', 'block');

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
