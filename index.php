<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

use Lib\Route;

require 'autoloader.php';

if (!isset($_GET['action'])) {
    $_GET['action'] = 'index';
}

if ($_GET['action'] == 'cron') {
    define('PRIVATE', true);
}

require 'Include/Guard.php';

Route::get('ping', 'Controllers\\PingController::pong');
Route::get('portal', 'Controllers\\PortalController::ShowPortal');