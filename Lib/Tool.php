<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Tool
{
    /*
     * Generate random HEX string
     * $length is an integer in bytes, 1 byte = 2 hex digits
     */
    public static function randomHex($length = 16) {
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        } else {
            if ($length > 16) {
                $randomHex = self::randomHex($length-16);
            } else {
                $randomHex = '';
            }
            return $randomHex.substr(md5(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')), 0, $length*2);
        }
    }

    public static function passwordHash($password, $randomString = '')
    {
        if (!$randomString) {
            $randomString = self::randomHex();
        }
        $hashString  = $randomString.$password.Config::get('salt');
        return array(
            'randomString' => $randomString,
            'hash' => function_exists('password_hash') ? password_hash($hashString, PASSWORD_BCRYPT) : sha1($hashString),
            'type' => function_exists('password_hash') ? 'internal' : 'sha1'
        );
    }

    public static function passwordVerify($password, $randomString, $type, $hash)
    {
        $hashString  = $randomString.$password.Config::get('salt');
        if ($type == 'internal') {
            return password_verify($hashString, $hash);
        } else {
            return sha1($password) == $hash;
        }
    }

    public static function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
