<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Request
{
    public static function getPost($name, $default = null)
    {
        if (isset($_POST[$name]) && $_POST[$name]) {
            return str_ireplace(['\'', '"'], '', $_POST[$name]);
        } else {
            return $default;
        }
    }

    public static function getRequest($name, $default = null)
    {
        if (isset($_REQUEST[$name]) && $_REQUEST[$name]) {
            return str_ireplace(['\'', '"'], '', $_REQUEST[$name]);
        } else {
            return $default;
        }
    }
}