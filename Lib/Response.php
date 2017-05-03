<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Response
{
    public static function returnMsg($url, $msg, $level = 'info') {
        if (Config::get('rewrite')) {
            header('Location: /'.$url.'?'.$level.'='.urlencode($msg));
        } else {
            header('Location: /?action='.$url.'&'.$level.'='.urlencode($msg));
        }
        exit;
    }
}