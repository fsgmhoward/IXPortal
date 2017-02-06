<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Controllers;

use Lib\Config;
use Lib\Database;

class CronController
{
    public static function run()
    {
        $autoLogoutInterval = Config::get('cron.auto_logout');
        if ($autoLogoutInterval) {
            $conn = Database::init();
            $conn->query("UPDATE `session` SET `status`='2' WHERE `updatetime`<'".(time()+$autoLogoutInterval)."';");
        }
        echo 'Cron OK';
    }
}
