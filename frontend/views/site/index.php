<?php
\Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' => trim(Yii::$app->setting->get("description")),
]);
\Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => 'rau, củ, quả, trái cây'
]);
\Yii::$app->view->registerMetaTag([
    'property' => "og:description",
    'content' => trim(Yii::$app->setting->get("description")),
]);
$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->urlManager->createAbsoluteUrl('/')]);
$this->registerMetaTag(['property' => 'og:image', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/images/logo_beta.png']);
$this->registerMetaTag(['property' => 'og:image:secure_url', 'content' => Yii::$app->setting->get('siteurl_cdn') . '/images/logo_beta.png']);
$this->registerMetaTag(['property' => 'og:image:alt', 'content' => 'Vinagex là sàn giao dịch nông sản Việt Nam']);
?>

<div id="home-page" class="container container-mobile">
    <section class="title-page">
        <h1><?= \Yii::t('frontend', 'Sàn giao dịch nông sản trực tuyến'); ?></h1>
        <p><?= \Yii::t('frontend', 'Hệ thống hỗ trợ kết nối và tiêu thụ nông sản hàng đầu Việt Nam'); ?></p>
    </section>
    <section class="home-sec" id="list-tab">
        <div class="wrap-tab">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#deal-new"><?= \Yii::t('frontend', 'Sản phẩm có sẵn'); ?></a></li>
                <li><a data-toggle="tab" href="#deal-today"><?= \Yii::t('frontend', 'Sản phẩm đặt trước'); ?></a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div id="deal-new" class="tab-pane fade in active">
                <div class="row list-product gird gird-5">
                    <?php
                    if (!empty($data['available'])) {
                        foreach ($data['available'] as $value) {
                            ?>
                            <div class="col-sm-3 col-lg-3 col">
                                <?= $this->render('/product/_item', ['model' => $value]) ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="viewmore"><a href="/filter?sell=1"><?= \Yii::t('frontend', 'Xem thêm'); ?><i class="fa fa-caret-right"></i></a> </div>
            </div>
            <div id="deal-today" class="tab-pane fade">
                <div class="row list-product gird gird-5">
                    <?php
                    if (!empty($data['is_reservation'])) {
                        foreach ($data['is_reservation'] as $value) {
                            ?>
                            <div class="col-sm-3 col-lg-3 col">
                                <?= $this->render('/product/_item', ['model' => $value]) ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="viewmore"><a href="/filter?sell=2"><?= \Yii::t('frontend', 'Xem thêm'); ?><i class="fa fa-caret-right"></i></a> </div>
            </div>
        </div>
    </section>
    <?php
    foreach ($data['category'] as $value) {

        if (!empty($value->parent)) {
            $product_type = array_slice($value->parent, 1, 3);
            ?>
            <section class="home-sec" id="category-<?= $value->slug ?>">
                <div class="block_header">
                    <h2 class="block_title"><a href="/filter?category=<?= $value->id ?>"><img src="/template/svg/<?= $value->icon ?>" width="25"> <?= Yii::t('common', trim($value->title)) ?></a></h2>
                    <div class="block_tab">
                        <ul class="tab nav nav-pills">
                            <li class="tab_item active"> <a data-toggle="tab" href="#<?= $value->slug ?>-available"><?= \Yii::t('frontend', 'Sản phẩm có sẵn'); ?></a> </li>
                            <li class="tab_item"> <a data-toggle="tab" href="#<?= $value->slug ?>-is_reservation"><?= \Yii::t('frontend', 'Sản phẩm đặt trước'); ?></a> </li>
                        </ul>
                    </div>
                    <div class="block_nav">
                        <ul>
                            <?php
                            foreach ($product_type as $type) {
                                ?>
                                <li><a href="/filter?category=<?= $value->id ?>&type%5B%5D=<?= $type['id'] ?>"><?= Yii::t('data', 'sub_category_' . $type['id']) ?></a> </li>
                                <?php
                            }
                            ?>
                            <li><a href="/filter?category=<?= $value->id ?>"><?= \Yii::t('frontend', 'Xem thêm'); ?> <i class="fa fa-long-arrow-right"></i></a> </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content tab-fix">
                    <div id="<?= $value->slug ?>-available" class="tab-pane fade in active">
                        <div class="row list-product gird gird-5">
                            <?php
                            foreach ($value->product(1) as $product) {
                                ?>
                                <div class="col-sm-3 col-lg-3 col">
                                    <?= $this->render('/product/_item', ['model' => $product]) ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="viewmore"><a href="/filter?category=<?= $value->id ?>&sell=1"><?= \Yii::t('frontend', 'Xem thêm'); ?> <?= \Yii::t('common', trim($value->title)); ?> <i class="fa fa-caret-right"></i></a> </div>
                    </div>
                    <div id="<?= $value->slug ?>-is_reservation" class="tab-pane fade ">
                        <div class="row list-product gird gird-5">
                            <?php
                            foreach ($value->product(2) as $product) {
                                ?>
                                <div class="col-sm-3 col-lg-3 col">
                                    <?= $this->render('/product/_item', ['model' => $product]) ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="viewmore"><a href="/filter?category=<?= $value->id ?>&sell=2"><?= \Yii::t('frontend', 'Xem thêm'); ?> <?= \Yii::t('common', trim($value->title)); ?> <i class="fa fa-caret-right"></i></a> </div>
                    </div>
                </div>
            </section>
            <?php
        }
    }
    ?>
</div>


