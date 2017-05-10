<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Response
{
    public static function returnMsg($url, $msg, $level = 'info', $extraParameter = '', $domain = '') {
        $location = Template::rewrite($url, $level.'='.urlencode($msg).$extraParameter, $domain, true);
        header('Location: '.$location);
        exit;
    }
}