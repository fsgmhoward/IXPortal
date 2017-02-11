<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

return array(
    'debug' => false, # this MUST be false when running in production environment
    'salt' => 'anything', # any random characters
    'open' => true, # enable (or not) for public registering
    'db' => array(
        'driver' => 'mysql', # currently only mysql is supported
        'host' => 'YOUR DB HOST',
        'user' => 'YOUR DB USER',
        'password' => 'YOUR DB PASSWORD',
        'name' => 'YOUR DB NAME',
        'long' => false # whether to enable long connection for DB
    ),
    'guard' => array(
        'cron' => true, # enable (or not) cron password
        'password' => 'IXPortal', # cron script password
        'csrf' => true, # enable (or not) CSRF referer checking
        'domain' => '192.168.1.1' # used for CSRF referer checking
    ),
    'cron' => array(
        'auto_logout' => 300 # Status of the session will be set to inactive(2) after this number of seconds. Set this to 0 to disable this function.
    )
);
