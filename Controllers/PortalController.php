<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Controllers;

use Lib\Database;
use Lib\Template;
use Lib\Config;
use Exception;

class PortalController
{
    /*
     * Wifidog will request the authentication server regularly to check whether the session is still active or not.
     */
    public static function showAuth() {
        // Get token and gw_id parameter from the query string
        $token = isset($_GET['token']) ? $_GET['token'] : null;
        $gw_id = isset($_GET['gw_id']) ? $_GET['gw_id'] : null;
        if (empty($token) || empty($gw_id)) {
            echo 'Auth: 0';
        } else {
            $db = new Database;
            // Check whether token is valid and still active
            $result = $db->query('SELECT * FROM `session` WHERE `token`="'.$token.'" AND `gw_id`="'.$gw_id.'" AND `status`="1";');
            if ($db->numRows($result)) {
                // Update last checking time
                $db->query('UPDATE `session` SET `updatetime`=now() WHERE `token`="'.$token.'" AND `gw_id`="'.$gw_id.'";');
                echo "Auth: 1";
            } else {
                echo "Auth: 0";
            }
        }
    }

    /*
     * When new user comes, Wifidog will redirect him or her to this page.
     */
    public static function showLogin()
    {
        Template::load('login', array('title' => 'Login'));
    }

    /*
     * Receive the form posted by the user (username and password).
     */
    public static function doLogin()
    {
        if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['remember'])) {
            throw new Exception('Invalid Input');
        } else {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $remember = $_POST['remember'];

            // Hash password
            $i = explode('a', $username);
            $hash = md5(md5(
                $i[0] . Config::get('salt') . $password . (isset($i[1]) ? $i[1] : '')
            ));

            $db = new Database;
            $result = $db->query('SELECT * FROM `user` WHERE `username`="'.$username.'" AND `password`="'.$hash.'";');
            if ($db->numRows($result)) {
                // TODO: Successfully authenticated
            } else {
                header('Location: ?action=login&error=1');
            }
        }
    }

    /*
     * Portal interface will be shown once the user successfully log in the system.
     */
    public static function showPortal()
    {
        Template::load('portal', array('title' => 'Successfully Logged In'));
    }
}