<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Controllers;

use Lib\Config;

class GuardController
{
    public static function password()
    {
        if (!isset($_GET['password']) || $_GET['password'] != Config::get('guard.password')) {
            throwException('ERR_INVALID_PASSCODE');
        }
    }

    public static function csrf()
    {
        if (isset($_SERVER['HTTP_REFERER']) && !preg_match('/https?:\/\/'.Config::get('guard.domain').'(:\d+)?\/.*/i', $_SERVER['HTTP_REFERER'])) {
            throwException('ERR_INVALID_REFERRER');
        }
    }
}
