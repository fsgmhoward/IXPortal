<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Database
{
    public static function init($name = null, $host = null, $user = null, $password = null, $long = null, $driver = null)
    {
        $config = Config::get('db');
        $host = $host ?: $config['host'];
        $user = $user ?: $config['user'];
        $password = $password ?: $config['password'];
        $name = $name ?: $config['name'];
        $long = $long !== null ? $long : $config['long'];
        $driver = array(
            'mysql' => extension_loaded('mysqli') ? Database\MysqliDriver::class : Database\MysqlDriver::class
        )[$driver ?: $config['driver']];
        return new $driver($host, $user, $password, $name, $long);
    }
}
