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

    $router = new Route();
    $router->get('index', 'Controllers\\HomeController::showIndex');
    $router->get('ping', 'Controllers\\PingController::pong');

    $router->get('auth', 'Controllers\\PortalController::showAuth');
    $router->get('portal', 'Controllers\\PortalController::showPortal');
    $router->get('login', 'Controllers\\PortalController::showLogin');
    $router->post('login', 'Controllers\\PortalController::doLogin');
    $router->get('register', 'Controllers\\PortalController::showRegister');
    $router->post('register', 'Controllers\\PortalController::doRegister');
    $router->get('logout', 'Controllers\\PortalController::showLogout');

    $router->get('cron', 'Controllers\\CronController::run');

    $router->exec();
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
