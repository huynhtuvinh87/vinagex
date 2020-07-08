<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

account\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <link rel="icon" href="<?= Yii::$app->setting->get('siteurl_cdn') ?>/main/favico.ico" />
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body id="login">
        <?php $this->beginBody() ?>
        <div id="content">
            <div class="container">
                <?= $content ?>
            </div>
        </div>
        <?php $this->endBody() ?>

    </body>
    <script>
        $('.select2-select').select2({

        });
    </script>
</html>
<?php $this->endPage() ?>
