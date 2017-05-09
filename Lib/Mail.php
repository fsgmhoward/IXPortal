<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

use Lib\Mail\SendgridDriver;

class Mail
{
    public static function init($configArray = null, $driver = null)
    {
        $config = Config::get('mail');
        $driver = $driver ?: $config['driver'];
        $driverClass = array(
            'sendgrid' => SendgridDriver::class
        )[$driver];
        $configArray = $configArray ?: $config[$driver];
        return new $driverClass($configArray);
    }
}
