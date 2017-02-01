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
            <div class="panel-heading"><h4>Logged out</h4></div>
            <div class="panel-body">
                <p>You have logged out of the system. The total time you logged in for this session is {{ $time }}.</p>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php';
?>
