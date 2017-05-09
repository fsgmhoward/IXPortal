<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

return array(
    'debug' => false, # this MUST be false when running in production environment
    'salt' => 'anything', # any random characters
    'open' => true, # enable (or not) for public registering
    'rewrite' => false, # set to true if request is rewritten (i.e. removed '?action=')
    'db' => array(
        'driver' => 'mysql', # currently only mysql is supported
        'host' => 'YOUR DB HOST',
        'user' => 'YOUR DB USER',
        'password' => 'YOUR DB PASSWORD',
        'name' => 'YOUR DB NAME',
        'long' => false # whether to enable long connection for DB
    ),
    'mail' => array(
        'driver' => 'sendgrid',
        'sendgrid' => array(
            'key' => 'YOUR SENDGRID API KEY',
            'from' => 'SENDER ADDRESS',
            'reply_to' => '', # leave empty to use 'from' as 'reply to' address
            'list_id' => 'YOUR SUBSCRIPTION LIST ID'
        )
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
