<?php

use yii\widgets\ListView;

$this->title = \Yii::t('common', 'Sản phẩm');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container container-mobile">
    <?= $this->render('menuMobile', ['model' => $model]) ?>
    <div id="main-content" class="company-content">
        <div id="content" class="grid-main">
            <div class="main-wrap">
                <div class="top-company">
                    <h3 class="title" title="<?= $model->garden_name ?>">
                        <?= $this->title ?>

                    </h3>

                    <div class="option">
                        <!--<a href="#" class="chat-now">!</a>-->
                        <?= $model->active['insurance_money'] == 1 ? "<a href='#' class='ubmit-order'>" . \Yii::t('common', 'Đã đóng bảo hiểm: ') . number_format($model->insurance_money) . " ₫</a>" : "" ?>
                    </div>

                </div>
                <div class="company-section">
                    <div class="comp-content">
                        <?=
                        ListView::widget([
                            'dataProvider' => $dataProviderProduct,
                            'options' => [
                                'tag' => 'div',
                                'id' => 'list-wrapper',
                                'class' => "list-product row gird"
                            ],
                            'itemOptions' => ['class' => 'col-sm-3 col-lg-3'],
                            'emptyText' => \Yii::t('common', 'Không có sản phẩm nào !'),
                            'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
                            'itemView' => '/product/_item',
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->render('sidebar', ['model' => $model]) ?>
    </div>
</div>