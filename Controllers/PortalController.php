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
    public static function showAuth()
    {
        // Get token and gw_id parameter from the query string
        $token = isset($_GET['token']) ? $_GET['token'] : null;
        $mac = isset($_GET['mac']) ? $_GET['mac'] : null;
        $gwID = isset($_GET['gw_id']) ? $_GET['gw_id'] : null;
        if (empty($token) || empty($gw_id)) {
            echo 'Auth: 0';
        } else {
            $db = new Database;
            // Check whether token is valid and still active
            $result = $db->query("SELECT * FROM `session` WHERE `token`='$token' AND `gw_id`='$gwID' AND `mac`='$mac' AND `status` IS TRUE;");
            if ($db->numRows($result)) {
                // Update last checking time
                $db->query("UPDATE `session` SET `updatetime`=now() WHERE `token`='$token' AND `gw_id`='$gwID';");
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
        $array = array();
        $array['title'] = 'Login';
        $array['gw_address'] = isset($_GET["gw_address"]) ? $_GET["gw_address"] : null;
        $array['gw_port'] = isset($_GET["gw_port"]) ? $_GET["gw_port"] : null;
        $array['gw_id'] = isset($_GET["gw_id"]) ? $_GET["gw_id"] : null;
        $array['mac'] = isset($_GET["mac"]) ? $_GET["mac"] : null;
        $array['url'] = isset($_GET["url"]) ? $_GET["url"] : null;
        if (empty($array['gw_address']) || empty($array['gw_port']) || empty($array['gw_id']) || empty($array['mac'])) {
            throw new Exception('Invalid Input');
        }
        if (isset($_COOKIE['token']) && isset($_COOKIE['gw_id']) && $_COOKIE['gw_id']  == $array['gw_id']) {
            // Found token in cookie, check its validity
            $db = new Database;
            $result = $db->query("SELECT * FROM `session` WHERE `token`={$_COOKIE['token']} AND `gw_id`={$_COOKIE['gw_id']};");
            if ($result && $db->numRows($result)) {
                // Cookie validated, Re-activate session
                $result = $db->query("UPDATE `session` SET `status`=TRUE WHERE `token`={$_COOKIE['token']} AND `gw_id`={$_COOKIE['gw_id']};");
                if (!$result) {
                    throw new Exception('Database Query Error');
                }
                if ($remember = isset($_COOKIE['remember']) ? $_COOKIE['remember'] : null) {
                    setcookie('token', $_COOKIE['token'], time() + $remember * 86400);
                    setcookie('gw_id', $_COOKIE['gw_id'], time() + $remember * 86400);
                    setcookie('remember', $remember, time() + $remember * 86400);
                }
                header("Location: http://{$array['gw_address']}:{$array['gw_port']}/wifidog/auth?token={$_COOKIE['token']}");
            } else {
                // Remove invalid cookie
                setcookie('token', '', time()-1);
            }
        }
        Template::load('login', $array);
    }

    /*
     * Receive the form posted by the user (username and password).
     */
    public static function doLogin()
    {
        $gwAddress = isset($_GET["gw_address"]) ? $_GET["gw_address"] : null;
        $gwPort = isset($_GET["gw_port"]) ? $_GET["gw_port"] : null;
        $gwID = isset($_GET["gw_id"]) ? $_GET["gw_id"] : null;
        $mac = isset($_GET["mac"]) ? $_GET["mac"] : null;
        $url = isset($_GET["url"]) ? $_GET["url"] : null;
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $remember = isset($_POST['remember']) ? $_POST['remember'] : null;
        if (empty($gwAddress) || empty($gwPort) || empty($gwID) || empty($mac) || empty($username) || empty($password)) {
            throw new Exception('Invalid Input');
        } else {
            // Hash password
            $i = explode('a', $username);
            $hash = md5(md5(
                $i[0] . Config::get('salt') . $password . (isset($i[1]) ? $i[1] : '')
            ));

            $db = new Database;
            $result = $db->query("SELECT * FROM `user` WHERE `username`='".$username."' AND `password`='".$hash."';");
            if ($result && $db->numRows($result)) {
                $uid = $db->fetch_array($result);
                $uid = $uid['id'];
                $token = "";
                $pattern="1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ";
                for ($i=0; $i<60; $i++) {
                    $token .= $pattern{mt_rand(0, 35)};
                }
                $token=md5($token);
                // Insert token to the database
                $result = $db->query("INSERT INTO `session` (`token`, `uid`, `gw_id`, `mac`, `url`) VALUES ('$token', '$uid', '$gwID', '$mac', ".($url ? "'$url'" : "NULL").");");
                if (!$result) {
                    throw new Exception('Database Query Error');
                } else {
                    // Set Cookie
                    setcookie('token', $token, time() + $remember * 86400);
                    setcookie('gw_id', $gwID, time() + $remember * 86400);
                    setcookie('remember', $remember, time() + $remember * 86400);
                    setcookie('username', $username);
                    setcookie('url', $url);
                    // Redirect user back to WifiDog
                    header("Location: http://$gwAddress:$gwPort/wifidog/auth?token=$token");
                }
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
