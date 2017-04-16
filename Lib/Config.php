<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

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
                    throwException('ERR_INVALID_CONFIG_INDEX', $index);
                }
            }
            return $config;
        } else {
            return self::$config;
        }
    }

    public static function set($name, $value)
    {
        if (!self::$config) {
            self::load();
        }
        $names = explode('.', $name);
        $v = array(&self::$config);
        foreach ($names as $name) {
            $v[] = &$v[sizeof($v)-1][$name];
        }
        $v[sizeof($v)-1] = $value;
    }
}
