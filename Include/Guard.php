<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

use Lib\Config;

if (Config::get('guard.cron') && $_GET['action'] == 'cron') {
    if ($_GET['password'] != Config::get('guard.password')) {
        throwException('ERR_INVALID_PASSCODE');
    }
}

if (Config::get('guard.csrf')) {
    if (isset($_SERVER['HTTP_REFERER']) && !preg_match('/https?:\/\/'.Config::get('guard.domain').'(:\d+)?\/.*/i', $_SERVER['HTTP_REFERER'])) {
        throwException('ERR_INVALID_REFERRER');
    }
}
