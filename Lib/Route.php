<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Route
{
    public static function get($route, $callback) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == $route) {
            call_user_func($callback);
            exit;
        }
    }

    public static function post($route, $callback) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['action'] == $route) {
            call_user_func($callback);
            exit;
        }
    }
}