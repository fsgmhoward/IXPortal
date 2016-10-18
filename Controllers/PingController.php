<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Controllers;

class PingController
{
    /*
     * Wifidog will regularly check authentication server's status by sending a 'ping' request,
     * and we should reply it by 'Pong'.
     */
    public static function pong()
    {
        echo 'Pong';
    }
}