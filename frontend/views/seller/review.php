<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\ListView;

$star1 = $model->countstar(1);
$star2 = $model->countstar(2);
$star3 = $model->countstar(3);
$star4 = $model->countstar(4);
$star5 = $model->countstar(5);


$this->title = \Yii::t('common', 'Đánh giá và nhận xét');
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
                        <!--<a href="#" class="supplier-feedback"><i class="fa fa-envelope" aria-hidden="true"></i>Liên hệ nhà cung cấp</a>-->
                         <?= $model->active['insurance_money'] == 1 ? "<a href='#' class='ubmit-order'>".\Yii::t('common', 'Đã đóng bảo hiểm: ').number_format($model->insurance_money)." ₫</a>" : "" ?>
                    </div>

                </div>
                <div class="company-section">
                    <div class="comp-content">

                        <div class="sec-pro sec-review">
                            <div class="sec-content" style="padding: 15px 0">
                                <div class="mod-rating">
                                    <div class="mod-content">
                                        <div class="left">
                                            <div class="mod-summary">
                                                <div class="score"> <span>
                                                        <?php
                                                        if (($star1 + $star2 + $star3 + $star4 + $star5) > 0) {
                                                            $total = (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) / ($star1 + $star2 + $star3 + $star4 + $star5);
                                                        } else {
                                                            $total = 0;
                                                        }
                                                        echo round($total, 0);
                                                        ?>
                                                    </span> <?= \Yii::t('common', 'trên') ?> 5 </div>
                                                                            <div class="star">
                                                    <div class="empty-stars"></div>
                                                        <div class="full-stars" style="width:<?= $model->getTotalReview() * 20 ?>%"> </div>
                                                    </div>
                                                      <div class="count">( <?= $model->countReview ?> <?= \Yii::t('common', 'Đánh giá') ?> )</div>
                                            </div>
                                            <div class="detail">
                                                <ul>
                                                    <li> <span class="text">5 <?= \Yii::t('common', 'Sao') ?></span> <span class="progress-wrap">   
                                                            <div class="review-progress">
                                                                <div class="bar bg"></div>
                                                                <div class="bar fg" style="width:<?= $star5 > 0 ? round($star5 * 5 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>       
                                                            </div>                                                
                                                        </span>
                                                        <span class="percent"><?= $star5 ?></span>
                                                    </li>
                                                    <li> <span class="text">4 <?= \Yii::t('common', 'Sao') ?></span> <span class="progress-wrap">
                                                            <div class="review-progress">
                                                                <div class="bar bg"></div>   
                                                                <div class="bar fg" style="width:<?= $star4 > 0 ? round($star4 * 4 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>
                                                            </div>
                                                        </span>
                                                        <span class="percent"><?= $star4 ?></span>
                                                    </li>
                                                    <li> <span class="text">3 <?= \Yii::t('common', 'Sao') ?></span> <span class="progress-wrap">
                                                            <div class="review-progress">
                                                                <div class="bar bg"></div>
                                                                <div class="bar fg" style="width:<?= $star3 > 0 ? round($star3 * 3 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>
                                                            </div>
                                                        </span>
                                                        <span class="percent"><?= $star3 ?></span>
                                                    </li>
                                                    <li> <span class="text">2 <?= \Yii::t('common', 'Sao') ?></span> <span class="progress-wrap">                                                   
                                                            <div class="review-progress">                                                     
                                                                <div class="bar bg"></div>                                                       
                                                                <div class="bar fg" style="width:<?= $star2 > 0 ? round($star2 * 2 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>                                                 
                                                            </div>                                               
                                                        </span>
                                                        <span class="percent"><?= $star2 ?></span>
                                                    </li>
                                                    <li> <span class="text">1 <?= \Yii::t('common', 'Sao') ?></span> <span class="progress-wrap">                                                   
                                                            <div class="review-progress">                                                     
                                                                <div class="bar bg"></div>                                                       
                                                                <div class="bar fg" style="width:<?= $star1 > 0 ? round($star1 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>                                                 
                                                            </div>                                               
                                                        </span>
                                                        <span class="percent"><?= $star1 ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?=
                            ListView::widget([
                                'dataProvider' => $dataProviderReview,
                                'options' => [
                                    'tag' => 'div',
                                    'id' => 'list-review-seller',
                                    'class' => 'mod-reviews'
                                ],
                                'emptyText' => \Yii::t('common', 'Không có đánh giá nào !'),
                                'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
                                'itemView' => '/review/_item',
                            ]);
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?= $this->render('sidebar', ['model' => $model]) ?>
    </div>
</div>