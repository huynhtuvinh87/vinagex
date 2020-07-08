<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\ListView;

$star1 = $product->countstar(1);
$star2 = $product->countstar(2);
$star3 = $product->countstar(3);
$star4 = $product->countstar(4);
$star5 = $product->countstar(5);
?>
<div class="sec-pro sec-review" id="section-review">
    <h3 class="sec-title"><?= \Yii::t('common', 'Đánh giá và nhận xét') ?> (<?=$product->countReview?>)</h3>
    <div class="sec-content">
        <div class="mod-rating">
            <div class="mod-content">
                <div class="left">
                    <div class="mod-summary <?= $product->countReview > 0 ? "" : "review_disable" ?>">
                        <?php
                        if ($product->countReview > 0){
                            ?>
                            <div class="score"> 
                                <span>
                                    <?php
                                    if (($star1 + $star2 + $star3 + $star4 + $star5) > 0) {
                                        $total = (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) / ($star1 + $star2 + $star3 + $star4 + $star5);
                                    } else {
                                        $total = 0;
                                    }
                                    echo round($total, 1);
                                    ?>
                                </span> <?= Yii::t('common', 'trên')?> 5 
                            </div>
                            <div class="star">
                                <div class="empty-stars"></div>
                                <div class="full-stars" style="width:<?= $product->getTotalReview() * 20 ?>%"> </div>
                            </div>
                            <div class="count"><?= $product->countReview ?> <?= \Yii::t('common', 'Đánh giá') ?></div>
                           
                    </div>
                    <div class="detail <?= $product->countReview > 0 ? "" : "review_disable" ?>">
                        <ul>
                            <li> <span class="text">5 <?= Yii::t('common', 'Sao')?></span> <span class="progress-wrap ">   
                                    <div class="review-progress">
                                        <div class="bar bg"></div>
                                        <div class="bar fg" style="width:<?= $star5 > 0 ? round($star5 * 5 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>       
                                    </div>                                                
                                </span>
                                <span class="percent"><?= $star5 ?></span>
                            </li>
                            <li> <span class="text">4 <?= Yii::t('common', 'Sao')?></span> <span class="progress-wrap">
                                    <div class="review-progress">
                                        <div class="bar bg"></div>   
                                        <div class="bar fg" style="width:<?= $star4 > 0 ? round($star4 * 4 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>
                                    </div>
                                </span>
                                <span class="percent"><?= $star4 ?></span>
                            </li>
                            <li> <span class="text">3 <?= Yii::t('common', 'Sao')?></span> <span class="progress-wrap">
                                    <div class="review-progress">
                                        <div class="bar bg"></div>
                                        <div class="bar fg" style="width:<?= $star3 > 0 ? round($star3 * 3 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>
                                    </div>
                                </span>
                                <span class="percent"><?= $star3 ?></span>
                            </li>
                            <li> <span class="text">2 <?= Yii::t('common', 'Sao')?></span> 
                                <span class="progress-wrap">                                                   
                                    <div class="review-progress">                                                     
                                        <div class="bar bg"></div>                                                       
                                        <div class="bar fg" style="width:<?= $star2 > 0 ? round($star2 * 2 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>                                                 
                                    </div>                                               
                                </span>
                                <span class="percent"><?= $star2 ?></span>
                            </li>
                            <li> <span class="text">1 <?= Yii::t('common', 'Sao')?></span> <span class="progress-wrap">                                                   
                                    <div class="review-progress">                                                     
                                        <div class="bar bg"></div>                                                       
                                        <div class="bar fg" style="width:<?= $star1 > 0 ? round($star1 / (($star5 * 5) + ($star4 * 4) + ($star3 * 3) + ($star2 * 2) + ($star1 * 1)) * 100, 0) : 0 ?>%"></div>                                                 
                                    </div>                                               
                                </span>
                                <span class="percent"><?= $star1 ?></span>
                            </li>
                        </ul>
                    </div>
                     <?php
                        } else {
                            echo  \Yii::t('common', 'Không có đánh giá nào !');
                        }
                        ?>
                </div>
                <div class="right">
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        ?>
                        <button type="button" data-href="/review/index/<?= $product->id ?>" class="next-btn btn-rate modal-review"><?= \Yii::t('common', 'Đánh giá sản phẩm này') ?></button>
                        <?php
                    } else {
                        ?>
                        <a href="<?= Yii::$app->setting->get('siteurl_id') ?>/login?url=<?= Yii::$app->urlManager->createAbsoluteUrl([$product->slug . '-' . $product->id]) ?>" class="next-btn btn-rate btn"><?= \Yii::t('common', 'Đánh giá sản phẩm này') ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

        <?php
             if ($product->countReview > 0) {
        ?>
    <div class="<?= $product->countReview > 0 ? "" : "review_disable" ?>">
        
        <div class="mod-filter-sort"> <span class="title"><?= \Yii::t('common', 'Nhận xét về sản phẩm') ?></span>
            <!--        <div class="oper">
                        <div class="dropdown">
                            <div class="text" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-filter" aria-hidden="true"></i> <span>Sắp xếp:</span> <span class="condition">Liên quan</span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Liên quan</a>
                                <a class="dropdown-item" href="#">Gần đây</a>
                                <a class="dropdown-item" href="#">Đánh giá: Từ cao đến thấp</a>
                                <a class="dropdown-item" href="#">Đánh giá: Từ thấp đến cao</a>
                            </div>
                        </div>
                    </div>
                    <div class="oper">
                        <div class="dropdown">
                            <div class="text" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-arrows-v" aria-hidden="true"></i> <span>Lọc:</span> <span class="condition">Tất cả sao</span>
                            </div>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">5 sao</a>
                                <a class="dropdown-item" href="#">4 sao</a>
                                <a class="dropdown-item" href="#">3 sao</a>
                                <a class="dropdown-item" href="#">2 sao</a>
                                <a class="dropdown-item" href="#">1 sao</a>
                            </div>
                        </div>
                    </div>-->
        </div>
        <?=
        ListView::widget([
            'dataProvider' => $dataProviderReview,
            'options' => [
                'tag' => 'div',
                'id' => 'list-review',
                'class' => 'mod-reviews'
            ],
            'emptyText' => \Yii::t('common', 'Không có đánh giá nào !'),
            'layout' => "{items}\n<div class='col-sm-12 pagination-page'>{pager}</div>",
            'itemView' => '/review/_item',
        ]);
        ?>
         <?php } ?>
    </div>
   
</div>
<?php ob_start(); ?>
<script type="text/javascript">
    $('.modal-review').click(function () {
        $.get($(this).attr('data-href'), function (data) {
            $('#modal-review').modal('show').find('#modalContent').html(data)
        });
        return false;
    });
</script>
<?php $this->registerJs(preg_replace('~^\s*<script.*>|</script>\s*$~ U', '', ob_get_clean())) ?>
<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'header' => '<span>'.\Yii::t('common', 'Đánh giá và nhật xét').'</span>',
    'id' => 'modal-review',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'><div style=\"text-align:center\"><img src=\"/template/images/loading.gif\"></div></div>";
yii\bootstrap\Modal::end();
?>