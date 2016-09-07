<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Controllers;

use Lib\Template;

class PortalController
{
    public static function showPortal()
    {
        Template::load('portal');
    }
}