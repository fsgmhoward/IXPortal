<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Database
{
    public static function init()
    {
        $config = Config::get('db');
        $driver = array(
            'mysql' => extension_loaded('mysqli') ? Database\MysqliDriver::class : Database\MysqlDriver::class
        )[$config['driver']];
        return new $driver($config['host'], $config['user'], $config['password'], $config['name'], $config['long']);
    }
}
