<div class="media" style="margin-bottom: 20px">
    <div class="media-body">
        <h4 class="media-heading"><?= $model->name ?></h4>
        <?= $model->content ?>
        <div class='rating-stars'>
                <div class="rating">
                <?php
                for ($i = 1; $i < 6; $i++) {
                    if ($i <= $model->star) {
                        echo '<i class="fa fa-star"></i>';
                    } else {
                        echo '<i class="fa fa-star-o"></i>';
                    }
                };
                ?>
                </div>
        </div>
    </div>
</div>