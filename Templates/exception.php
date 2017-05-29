<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

use Lib\Config;
?>

<!DOCTYPE html>
<html lang="{{ trans('translations.translation_information.language">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Exception Thrown</title>

    <!-- Fonts -->
    <link href="/Resources/fonts/font-awesome/font-awesome.css" rel='stylesheet' type='text/css'>
    <link href="/Resources/fonts/Lato/latofonts.css" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="/Resources/css/bootstrap.min.css" rel='stylesheet' type='text/css'>
    <style>
        /*
     * Some styles brought by make:auth command of Laravel Framework
     */
        body {
            font-family: Lato, 'Microsoft YaHei UI Light', sans-serif;
        }

        /*
         * Sticky footer styles
         * Originally from http://getbootstrap.com/examples/sticky-footer/sticky-footer.css
         */
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            margin-bottom: 54px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 54px;
            background-color: #f5f5f5;
        }
        .container .text-muted {
            font-size: 14px;
            margin: 20px 0;
        }
    </style>
</head>
<body id="app-layout">
<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Exception Thrown</h4></div>
                <div class="panel-body">
                    <p><strong>Code: </strong>{{ $code }}</p>
                    <p><strong>Name: </strong>{{ $message }}</p>
                    <?php if (($config = Config::get())['debug']) { ?>
                        <hr size="2px">
                        <p><strong>Trace:</strong>{{ $trace }}</p>
                        <p>
                            <strong>Current Configuration:</strong><br/>
                            <?php var_dump($config); ?>
                        </p>
                    <?php } ?>
                    <hr size="2px">
                    <p><strong>You may use these information to contact your network administrator for help.</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted">{{ $powered_by }}</p>
    </div>
</footer>
</body>
</html>