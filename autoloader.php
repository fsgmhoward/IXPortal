<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

function __autoload($className)
{
    require_once str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
}
