<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

$config = array(
    'debug' => false, # this MUST be false when running in production environment
    'salt' => 'anything', # any random characters
    'open' => true, # enable (or not) for public registering
    'db' => array(
        'host' => 'YOUR DB HOST',
        'user' => 'YOUR DB USER',
        'password' => 'YOUR DB PASSWORD',
        'name' => 'YOUR DB NAME'
    ),
    'guard' => array(
        'cron' => true, # enable (or not) cron password
        'password' => 'IXPortal', # cron script password
        'csrf' => true, # enable (or not) CSRF referer checking
        'domain' => '192.168.1.1' # used for CSRF referer checking
    )
);
