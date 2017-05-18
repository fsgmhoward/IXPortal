<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

use Lib\Config;
use Lib\Route;
use Lib\Template;

require 'Include/Exception.php';

try {
    require 'autoloader.php';

    $router = new Route();
    if (Config::get('guard.cron')) {
        $router->regMiddleware('cron', 'Controllers\\GuardController::password');
    }
    if (Config::get('guard.csrf')) {
        $router->regMiddleware('all', 'Controllers\\GuardController::csrf');
    }
    $router->get('cron', 'Controllers\\CronController::run', 'cron');

    // Register your route below

    $router->exec();
} catch (Exception $e) {
    http_response_code(500);
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
