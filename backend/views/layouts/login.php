<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Adminstrator - FILMCMS! | </title>

        <!-- Bootstrap core CSS -->

        <link href="/css/bootstrap.min.css" rel="stylesheet">

        <link href="/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="/css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="/css/custom.css" rel="stylesheet">
        <link rel="shortcut icon" href="/favicon.ico">

        <!--[if lt IE 9]>
            <script src="../assets/js/ie8-responsive-file-warning.js"></script>
            <![endif]-->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
        <style>
            body{
                background: #f1f1f1;
            }
            #login{
                margin: 0 auto;
                max-width: 300px;
                margin-top: 8%;
            }
            #login .logo{
                text-align: center;
                margin-bottom: 20px
            }
            #login .logo img{
                width: 250px;
            }
            .login_content {

                background-color: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,.13);
                padding: 25px;

            }
            #login .lostpassword{
                text-align: center;
                margin-top: 10px
            }

        </style>
    </head>

    <body>

        <div class="">
            <div id="wrapper">

                <div id="login">
                    <div class="logo">
                        <img src="https://s3-ap-southeast-1.amazonaws.com/giataivuon/logo.png">
                    </div>

                    <?= $content ?>
                    <!-- content -->
                </div>

            </div>
        </div>

    </body>

</html>