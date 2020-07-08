<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use common\widgets\Alert;
use backend\widgets\SidebarWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!--[if lt IE 9]>
            <script src="../assets/js/ie8-responsive-file-warning.js"></script>
            <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        <style>
            input[type=checkbox][disabled] {
                color: #6c757d;
                opacity: 0.3;
            }
        </style>
    </head>


    <body class="nav-md">
        <?php $this->beginBody() ?>
        <div class="container body">


            <div class="main_container" style="background: #2A3F54;">
                <?php
                if (!\Yii::$app->user->isGuest) {
                    ?>

                    <div class="col-md-3 left_col">
                        <?= SidebarWidget::widget() ?>
                    </div>

                    <!-- top navigation -->
                    <div class="top_nav">

                        <div class="nav_menu">
                            <nav class="" role="navigation">
                                <div class="nav toggle">
                                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                                </div>

                                <ul class="nav navbar-nav navbar-right">

                                    <li>
                                        <?php
                                        if (!Yii::$app->user->isGuest) {
                                            ?>
                                            <a href="javascript:void(0)" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <?= 'Xin chào: ' . Yii::$app->user->identity->username ?>
                                                <span class=" fa fa-angle-down"></span>
                                            </a>
                                        <?php } ?>
                                        <?php
                                        echo Menu::widget([
                                            'encodeLabels' => false,
                                            'items' => [
                                                ['label' => 'Cập nhật tài khoản', 'url' => ['user/profile']],
                                                ['label' => 'Thay đổi mật khẩu', 'url' => ['user/changepassword']],
                                                ['label' => '<i class="fa fa-sign-out pull-right"></i> ' . \Yii::t('app', 'Logout'), 'url' => ['site/logout']],
                                            ],
                                            'options' => [
                                                'class' => 'dropdown-menu dropdown-usermenu animated fadeInDown pull-right',
                                            ],
                                        ]);
                                        ?>
                                    </li>
                                    <li><a href="/notification">Thông báo <span class="badge count_notify"></span></a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                    <!-- /top navigation -->


                    <!-- page content -->
                    <div class="right_col" role="main">
                        <div>
                            <?=
                            Breadcrumbs::widget([
                                'homeLink' => [
                                    'label' => Yii::t('yii', 'Dashboard'),
                                    'url' => Yii::$app->homeUrl,
                                ],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ])
                            ?>
                        </div>


                        <?= Alert::widget() ?>

                        <!-- top tiles -->
                        <?= $content ?>
                    </div>
                    <!-- /page content -->
                    <?php
                } else {
                    echo $content;
                }
                ?>

            </div>

        </div>


        <?php $this->endBody() ?>
        <script>
            function handleFileSelect() {
                //Check File API support
                if (window.File && window.FileList && window.FileReader) {

                    var files = event.target.files; //FileList object
                    var output = document.getElementById("result");

                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        //Only pics
                        if (!file.type.match('image'))
                            continue;

                        var picReader = new FileReader();
                        picReader.addEventListener("load", function (event) {
                            var picFile = event.target;
                            var div = document.createElement("div");
                            div.className = 'col-sm-3 img-item';
                            div.innerHTML = "<label><a href='javascript:void(0)'><i class='fa fa-trash' style='position: absolute;top: 5px; right: 5px'></i></a><img src='" + picFile.result + "' style='width:100%;' class='img-thumbnail'/></label>";
                            output.insertBefore(div, null);
                        });
                        //Read the image
                        picReader.readAsDataURL(file);
                    }
                } else {
                    console.log("Your browser does not support File API");
                }
            }
            ;
            $('.select2-select').select2();
        </script>
    </body>

</html>
<?php $this->endPage() ?>