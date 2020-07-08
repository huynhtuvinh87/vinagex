<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use seller\assets\SellerAsset;
use common\widgets\Alert;
use \common\components\Constant;

SellerAsset::register($this);
$cookies = Yii::$app->request->cookies;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div class=" container-fluid" style="min-height:1000px;">
            <?= $content ?>
        </div>

        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
