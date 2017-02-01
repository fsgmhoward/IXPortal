<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

require 'header.php';
$open = \Lib\Config::get('open');
?>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Login</h4></div>
                <div class="panel-body">
                    <form class="form-horizontal" action="?action=login&gw_id={{ $gw_id }}&gw_address={{ $gw_address }}&gw_port={{ $gw_port }}&mac={{ $mac }}&url={{ $url }}" method="post">
                        <?php
                        $error = array(
                            '1' => 'Invalid Username or Password'
                        );
                        $info = array(
                            '1' => 'Successfully Registered'
                        );
                        if (isset($_GET['error']) && isset($error[$_GET['error']])) {
                            echo '<div class="alert alert-danger">'.$error[$_GET['error']].'</div>';
                        }
                        if (isset($_GET['info']) && isset($info[$_GET['info']])) {
                            echo '<div class="alert alert-info">'.$info[$_GET['info']].'</div>';
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
                            <label for="remember" class="control-label col-sm-3">Remember Me</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="remember" name="remember">
                                    <option value="0" selected>Never</option>
                                    <option value="1">1 Day</option>
                                    <option value="7">1 Week</option>
                                    <option value="30">1 Month</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-<?php echo $open ? '6' : '9'; ?>">
                                <button class="btn btn-default form-control" type="submit" name="submit">Log Me In!</button>
                            </div>
                            <?php
                            if ($open) { ?>
                                <div class="col-sm-3">
                                    <a href="?action=register&gw_id={{ $gw_id }}&gw_address={{ $gw_address }}&gw_port={{ $gw_port }}&mac={{ $mac }}&url={{ $url }}" class="btn btn-primary form-control">Register</a>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
require 'footer.php';
?>