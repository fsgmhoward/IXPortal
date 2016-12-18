<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Database
{
    static function init($long = false)
    {
        $config = Config::get('db');
        if (extension_loaded('mysqli')) {
            $class = 'Lib\Database\MySQLi';
        } else {
            $class = 'Lib\Database\MySQL';
        }
        return new $class($config['host'], $config['user'], $config['password'], $config['name'], $long);
    }
}
