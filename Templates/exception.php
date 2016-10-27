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
            <div class="panel-heading"><h4>Uncaught Exception Thrown</h4></div>
            <div class="panel-body">
                <p><strong>Code:</strong> {{ $code }}</p>
                <p><strong>Message:</strong> {{ $message }}</p>
                <?php if (\Lib\Config::get('debug')) { ?>
                    <p><strong>Trace:</strong></p>
                    <p>{{ $trace }}</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php';
?>
