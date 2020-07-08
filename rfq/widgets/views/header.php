<?php

use yii\helpers\Html;
use yii\helpers\Url;

if (isset($_GET['category']) && $_GET['category'] != NULL && $_GET['category'] != 0) {
    $category_title = $category[array_search($_GET['category'], array_column($category, '_id'))]['title'];
} else {
    $category_title = Yii::t('common', 'Tất cả danh mục');
}
?>
<?php
$html = '<li><a class="item-category" data-category="' . 0 . '" href="javascript:void(0)">' . Yii::t('common', 'Tất cả danh mục') . '</a></li>';
foreach ($category as $value) {
    $html .= '<li><a class="item-category" data-category="' . $value->id . '" href="javascript:void(0)">' . Yii::t('data', $value['title']) . '</a></li>';
}
?>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 col-xs-6">
                <div class="logo">
                    <a href="<?= Yii::$app->setting->get('siteurl') ?>"><img width="225" src="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/logo.png"></a>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 form-search form-search-desktop">
                <form action="/?" method="get">
                    <div class="input-group search-wrap input-group-lg">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle title-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= $category_title ?> <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <?= $html ?>
                            </ul>
                            <input type="hidden" id="search_category" name="category" value="<?= (!empty($_GET['category']) ? $_GET['category'] : 0) ?>">
                        </div>
                        <input placeholder="<?= Yii::t('common', 'Tìm kiếm') ?>" type="text" class="form-control text-search" name="keywords" value="<?= (!empty($_GET['keywords']) ? $_GET['keywords'] : '') ?>">
                        <span class="input-group-btn"><button type="submit"><span class = "glyphicon glyphicon-search"></span></button></span>
                    </div>
                </form>
            </div>
            <div class="col-sm-4 col-xs-6">
                <div class="menu-rfq pull-right">
                    <ul>
                        <li><?= Html::a(Yii::t('rfq', 'Trang chủ'), [Yii::$app->homeUrl]); ?></li> 
                        <li class="rfq_add"><?= Html::a('<img src="/svg/add.svg" width=18><span>' . Yii::t('rfq', 'Tạo yêu cầu') . '<span>', ['manager/create']); ?></li>
                        <li class="dropdown show language">
                            <a href="javascript:void(0)" class="dropdown-toggle language-bar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="language-name"><?= \Yii::t("common", "Ngôn ngữ") ?></span> <span class="lang-sm" lang="<?= Yii::$app->language ?>"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><?= Html::a('<span class="lang-sm lang-lbl-full" lang="vi"></span>', Url::current(['lang' => 'vi'])) ?></li> 
                                <li><?= Html::a('<span class="lang-sm lang-lbl-full" lang="en"></span>', Url::current(['lang' => 'en'])) ?></li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="col-sm-6 col-xs-12 form-search form-search-mobile">
            </div>
        </div>
    </div>
</div>