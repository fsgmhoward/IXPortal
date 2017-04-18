<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

use Lib\Route;
use Lib\Template;

require 'Include/Exception.php';

try {
    require 'autoloader.php';
    require 'Include/Guard.php';

    $router = new Route();
    $router->get('cron', 'Controllers\\CronController::run');

    // Register your route below

    $router->exec();
} catch (Exception $e) {
    $traceHTML = '';
    foreach ($e->getTrace() as $index => $trace) {
        $traceHTML .= "<br /><strong>#$index</strong> {$trace['function']}() @ {$trace['file']}({$trace['line']})";
    }
    Template::load('exception', array(
        'code' => $e->getCode(),
        'message' => $e->getMessage(),
        'trace' => $traceHTML
    ));
}
