<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */
require 'header.php';
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>Exception Thrown</h4></div>
            <div class="panel-body">
                <p><strong>Code:</strong>{{ $code }}</p>
                <p><strong>Name:</strong>{{ $message }}</p>
                <?php if (\Lib\Config::get('debug')) { ?>
                    <p><strong>Trace:</strong>{{ $trace }}</p>
                <?php } ?>
                <hr size="2px">
                <p><strong>You may use these information to contact your network administrator for help.</strong></p>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php';
?>
