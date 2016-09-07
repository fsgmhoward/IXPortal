<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

use Exception;

class Config
{
    private static $config = null;

    private static function load()
    {
        self::$config = require __DIR__ . '/../config.php';
    }

    public static function get($name = '')
    {
        if (!self::$config) {
            self::load();
        }
        if ($name) {
            $names = explode('.', $name);
            $config = self::$config;
            foreach ($names as $index) {
                if (isset($config[$index])) {
                    $config = $config[$index];
                } else {
                    throw new Exception('Invalid Config Index');
                }
            }
            return $config;
        } else {
            return self::$config;
        }
    }

    public static function set($name, $value)
    {
        //todo
    }
}