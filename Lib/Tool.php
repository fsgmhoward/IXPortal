<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Tool
{
    public static function hash($password)
    {
        $salt = Config::get('salt');
        return md5(md5(sha1($password.$salt).$salt).$salt);
    }
}
