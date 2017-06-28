<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

function __autoload($className)
{
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        throwException('ERR_CLASS_NOT_FOUND');
    }
}

if (file_exists('vendor') && file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
    spl_autoload_register('__autoload');
}