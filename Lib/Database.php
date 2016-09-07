<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

use Lib\Database\MySQLi;
use Lib\Database\MySQL;

class Database
{
    static function init($long = false)
    {
        $config = Config::get('db');
        if (extension_loaded('mysqli')) {
            return new MySQLi($config['host'], $config['user'], $config['password'], $config['name'], $long);
        } else {
            return new MySQL($config['host'], $config['user'], $config['password'], $config['name'], $long);
        }
    }
}