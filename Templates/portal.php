<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

require 'header.php';
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Authorized</h4></div>
            <div class="panel-body">
                <p>You have successfully authorized with your information and you can access the network now.</p>
                <p><strong>Please do not clear your browser cookie/cache until you have logged out of the system!</strong></p>
                <div class="row">
                    <div class="col-sm-12 col-lg-offset-3 col-lg-6">
                        <?php
                        if (isset($_COOKIE['url'])) {
                            echo '<a class="btn btn-block btn-primary" href="'.$_COOKIE['url'].'">Continue Browsing</a>';
                        }
                        ?>
                        <a class="btn btn-block btn-danger" href="?action=logout">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php';
?>
