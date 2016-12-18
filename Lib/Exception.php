<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

use Exception as SysException;
use Lib\Template;

class Exception
{
    public static function show(SysException $e)
    {
        Template::load('exception', array(
            'title' => 'Uncaught Exception Thrown',
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ));
    }
}
