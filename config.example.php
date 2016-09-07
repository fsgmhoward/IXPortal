<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

$config = array(
    'db' => array(
        'host' => 'YOUR DB HOST',
        'user' => 'YOUR DB USER',
        'password' => 'YOUR DB PASSWORD',
        'name' => 'YOUR DB NAME'
    ),
    'guard' => array(
        'cron' => true, # enable (or not) cron password
        'password' => 'IXPortal',
        'csrf' => true, # enable (or not) CSRF referer checking
        'domain' => '192.168.1.1' # used for CSRF referer checking
    )
);