<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Controllers;

use Lib\Template;

class HomeController
{
    public static function showIndex()
    {
        Template::load('index', array('title' => 'Welcome to use IX Portal'));
    }
}
