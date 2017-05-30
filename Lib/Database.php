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
        switch ($driver ?: $config['driver']) {
            case 'mysql':
                if (extension_loaded('mysqli')) {
                    return new Database\MysqliDriver($host, $user, $password, $name, $long);
                } else {
                    return new Database\MysqlDriver($host, $user, $password, $name, $long);
                }
            default:
                throwException('ERR_CLASS_NOT_FOUND');
        }
    }
}
