<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Controllers;

use Exception;
use Lib\Database;

class PingController
{
    /*
     * Wifidog will regularly check authentication server's status by sending a 'ping' request,
     * and we should reply it by 'Pong'.
     */
    public static function pong()
    {
        $db = Database::init();
        $db->close();
        // If any exception is thrown above, 'Pong' will not be returned, instead, a error message will be shown.
        echo 'Pong';
    }
}
