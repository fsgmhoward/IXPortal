<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

function __autoload($className)
{
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        throw new Exception('Class File Not Found');
    }
}
