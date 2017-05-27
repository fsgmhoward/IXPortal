<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Request
{
    public static function getPost($name = null, $default = null)
    {
        if ($name) {
            if (isset($_POST[$name]) && $_POST[$name] != '') {
                return str_ireplace(['\'', '"'], '', $_POST[$name]);
            } else {
                return $default;
            }
        } elseif (!empty($_POST)) {
            foreach ($_POST as $name => $value) {
                $_POST[$name] = str_ireplace(['\'', '"'], '', $value);
            }
            return $_POST;
        } else {
            return $default;
        }
    }

    public static function getRequest($name = null, $default = null)
    {
        if ($name) {
            if (isset($_REQUEST[$name]) && $_REQUEST[$name] != '') {
                return str_ireplace(['\'', '"'], '', $_REQUEST[$name]);
            } else {
                return $default;
            }
        } elseif (!empty($_REQUEST)) {
            foreach ($_REQUEST as $name => $value) {
                $_REQUEST[$name] = str_ireplace(['\'', '"'], '', $value);
            }
            return $_REQUEST;
        } else {
            return $default;
        }
    }
}