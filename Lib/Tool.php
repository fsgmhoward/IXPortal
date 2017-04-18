<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Tool
{
    public static function hash($password, $randomString = '')
    {
        if (!$randomString) {
            if (function_exists('random_bytes')) {
                $randomString = bin2hex(random_bytes(16));
            } elseif (function_exists('openssl_random_pseudo_bytes')) {
                $randomString = openssl_random_pseudo_bytes(16);
            } else {
                $randomString = md5(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'));
            }
        }
        $hashString  = $randomString.$password.Config::get('salt');
        return array(
            'randomString' => $randomString,
            'hash' => function_exists('password_hash') ? password_hash($hashString, PASSWORD_BCRYPT) : sha1($hashString)
        );
    }
}
