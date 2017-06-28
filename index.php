<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

use Lib\Config;
use Lib\Route;
use Lib\Template;

require 'Include/Exception.php';

$versionArray  = require 'Include/Version.php';
global $kernelName, $kernelVersion, $vendorName, $vendorVersion;
$kernelName    = $versionArray['kernel_name'];
$kernelVersion = $versionArray['kernel_version'];
$vendorName    = $versionArray['vendor_name'];
$vendorVersion = $versionArray['vendor_version'];

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
    $router->get('index', 'Controllers\\HomeController::showIndex');
    $router->get('ping', 'Controllers\\PingController::pong');

    $router->get('auth', 'Controllers\\PortalController::showAuth');
    $router->get('portal', 'Controllers\\PortalController::showPortal');
    $router->get('login', 'Controllers\\PortalController::showLogin');
    $router->post('login', 'Controllers\\PortalController::doLogin');
    $router->get('register', 'Controllers\\PortalController::showRegister');
    $router->post('register', 'Controllers\\PortalController::doRegister');
    $router->get('logout', 'Controllers\\PortalController::showLogout');

    $router->exec();
} catch (Exception $e) {
    http_response_code(500);
    $traceHTML = '';
    foreach ($e->getTrace() as $index => $trace) {
        $args = '';
        foreach ($trace['args'] as $arg) {
            $args = ','.$arg;
        }
        $args = ltrim($args, ',');
        if (isset($trace['file'])) {
            $traceHTML .= "<br /><strong>#$index {$trace['function']}(</strong>$args<strong>)</strong> @ {$trace['file']}({$trace['line']})";
        } else {
            $traceHTML .= "<br /><strong>#$index {$trace['function']}(</strong>$args<strong>)</strong> @ call_user_func()";
        }
    }
    Template::load('exception', array(
        'code' => $e->getCode(),
        'message' => $e->getMessage(),
        'trace' => $traceHTML
    ));
}
