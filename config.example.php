<?php
/*
 * IX Framework - A Simple MVC Framework
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
        'cron' => false, # enable (or not) cron password
        'password' => 'IXFramework', # cron script password
        'csrf' => false, # enable (or not) CSRF referer checking
        'domain' => '192.168.1.1' # used for CSRF referer checking
    ),
    'cron' => array(
        # Add whatever you want as config for cron scripts
    )
    # Add other config below
);
