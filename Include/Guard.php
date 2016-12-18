<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

use Lib\Config;

if (Config::get('guard.cron') && defined('PRIVATE')) {
    if ($_GET['password'] != Config::get('guard.password')) {
        throw new Exception('Permission Denied. Invalid Password');
    }
}

if (Config::get('guard.csrf')) {
    if (isset($_SERVER['HTTP_REFERER']) && !preg_match('/https?:\/\/'.Config::get('guard.domain').'\/.*/i', $_SERVER['HTTP_REFERER'])) {
        throw new Exception('Invalid Referer');
    }
}
