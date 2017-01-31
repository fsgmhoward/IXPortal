<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

require 'header.php';
if (!\Lib\Config::get('open')) {
    throw new Exception('This portal is not opened for register');
}
?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Login</h4></div>
                <div class="panel-body">
                    <form class="form-horizontal" action="?action=register&gw_id={{ $gw_id }}&gw_address={{ $gw_address }}&gw_port={{ $gw_port }}&mac={{ $mac }}&url={{ $url }}" method="post">
                        <?php
                        $error = array(
                            '1' => 'Username Exists',
                            '2' => 'Confirm Password Not Match'
                        );
                        if (isset($_GET['error']) && isset($error[$_GET['error']])) {
                            echo '<div class="alert alert-danger">'.$error[$_GET['error']].'</div>';
                        }
                        ?>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-3">Username</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" id="username" name="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label col-sm-3">Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" id="password" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="control-label col-sm-3">Confirm Password</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" id="confirm_password" name="confirm_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button class="btn btn-default form-control" type="submit" name="submit">Register and Log Me In!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
require 'footer.php';
?>
