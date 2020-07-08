<?php

use common\components\Constant;

\Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => trim(Constant::excerpt($product['content'], 155)),
]);
\Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => 'rau, củ, quả, trái cây'
]);
\Yii::$app->view->registerMetaTag([
    'property' => "og:description",
    'content' => trim(Constant::excerpt($product['content'], 155)),
]);

$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->urlManager->createAbsoluteUrl([$product['slug'] . '-' . (string) $product['_id']])]);
$this->registerMetaTag(['property' => 'og:image', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/' . $product['images'][0]]);
$this->registerMetaTag(['property' => 'og:image:secure_url', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/' . $product['images'][0]]);
$this->registerMetaTag(['property' => 'og:image:alt', 'content' => $product['title']]);
$this->params['breadcrumbs'][] = ['label' => \Yii::t('data', 'product_title_' . $product['_id']), 'url' => ['/' . $product['slug'] . '-' . (string) $product['_id']]];
$this->params['breadcrumbs'][] = \Yii::t('common', 'Thông tin mới nhất về {0}', \Yii::t('data', 'product_title_' . $product['_id']));
?>

<div class="container container-mobile product-image">
    <div class="row">
        <div class="col-sm-2 col-md-2 left">
            <nav class="time-image">
                <h4><?= Yii::t('common', 'Mốc thời gian') ?></h4>
                <?php
                foreach ($product_image as $value) {
                    ?>
                    <a href="javascript:void(0)" data-id="<?= (string) $value['_id'] ?>" class="description">
                        <p class="time"><?= date('h:i d/m/Y', $value['created_at']) ?></p>
                        <p><?= Constant::excerpt($value['content'], 100) ?></p>
                    </a>
                    <?php
                }
                ?>
            </nav>
        </div>
        <div class="col-sm-10 col-md-10 right pull-right">
            <h4><?= Yii::t('common', 'Thông tin mới nhất về {0}', '<a href="/' . $product['slug'] . '-' . $product['_id'] . '">' . Yii::t('data', 'product_title_' . $product['_id']) . '</a>') ?></h4>
            <p><small><a href="/nha-cung-cap/<?= $product['owner']['username'] ?>"><?= Yii::t('data', 'seller_garden_name_' . $product['owner']['id']) ?></a></small> <a href="javascript:void(0)" data-id="<?= $product['_id'] ?>" class="pull-right report"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?= Yii::t('common', 'Báo cáo') ?></a></p>
            <div class="image-item">
                <?php
                foreach ($product_image as $value) {
                    ?>
                    <div id="item-<?= (string) $value['_id'] ?>" class="item">
                        <div class="header">
                            <span><?= date('h:i d/m/Y', $value['created_at']) ?></span>
                        </div>
                        <div class="content">
                            <?= $value['content'] ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div id="stopHere" style="clear: both;"></div>
    </div>
</div>

<?php ob_start(); ?>
<script>

    $(document).scroll(function () {
        var navWrap = $('.product-image .left');
        var nav = $('.product-image .left nav');
        var startPosition = navWrap.offset().top;
        var stopPosition = $('#stopHere').offset().top - nav.outerHeight();
        var y = $(this).scrollTop();

        if (y > startPosition) {
            nav.css('position', 'fixed');
            nav.css('top', '0');
            if (y > stopPosition) {
                nav.css('top', stopPosition - y);
            } else {
                nav.css('top', 0);
            }
        } else {
            nav.css('position', 'relative');
        }
    });



    $("body").on("click", ".description", function (event) {
        var id = $(this).data('id');
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#item-" + id).offset().top
        }, 500);
    });

    $('.report').click(function () {
        $.get('/product/reportimage/' + $(this).attr('data-id'), function (data) {
            $('#modal-report').modal('show').find('#modalContentReport').html(data);
            $("#modal-report .modal-footer").show();
            $('#modal-report').find('.modal-footer').find('.btn-report').show();
        });
        return false;
    });

    $("body").on("click", '.btn-report', function (event, state) {
        var data = $('form#report-form').serializeArray();
        $.ajax({
            type: "POST",
            url: "/product/reportimage/<?= $product['_id'] ?>",
            data: $('form#report-form').serialize(),
            success: function (rs) {
                $('#modal-report').find('#modalContentReport').html(rs);
                $('#modal-report').find('.modal-footer').find('.btn-report').hide();
                return false
            },
        });
    });

</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>

<?php
yii\bootstrap\Modal::begin([
    'id' => 'modal-report',
    'header' => '<strong>Giúp chúng tôi hiểu điều gì đang xảy ra</strong>',
    'size' => 'modal-sm',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Huỷ</button> <button type="button" class="btn btn-primary btn-report">Gửi báo cáo</button>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContentReport'><div style=\"text-align:center\"><img src=\"/template/images/loading.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>