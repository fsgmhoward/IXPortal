<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

use Lib\Route;
use Lib\Template;

require 'Include/Exception.php';

$_GET['action'] = isset($_GET['action']) ? $_GET['action'] : 'index';

try {
    require 'autoloader.php';
    require 'Include/Guard.php';

    Route::get('index', 'Controllers\\HomeController::showIndex');
    Route::get('ping', 'Controllers\\PingController::pong');

    Route::get('auth', 'Controllers\\PortalController::showAuth');
    Route::get('portal', 'Controllers\\PortalController::showPortal');
    Route::get('login', 'Controllers\\PortalController::showLogin');
    Route::post('login', 'Controllers\\PortalController::doLogin');
    Route::get('register', 'Controllers\\PortalController::showRegister');
    Route::post('register', 'Controllers\\PortalController::doRegister');
    Route::get('logout', 'Controllers\\PortalController::showLogout');

    Route::get('cron', 'Controllers\\CronController::run');

    throwException('ERR_INVALID_ROUTE');
} catch (Exception $e) {
    $traceHTML = '';
    foreach ($e->getTrace() as $index => $trace) {
        $traceHTML .= "<br /><strong>#$index</strong> {$trace['function']}() @ {$trace['file']}({$trace['line']})";
    }
    Template::load('exception', array(
        'title' => 'Exception Thrown',
        'code' => $e->getCode(),
        'message' => $e->getMessage(),
        'trace' => $traceHTML
    ));
}
