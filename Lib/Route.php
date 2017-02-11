<?php
/*
 * IX Portal - Router Wifidog Portal used for authenticating users
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Route
{
    protected $routes = array();
    protected $method;
    protected $action;

    public function __construct()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'index';
    }

    /*
     * Register route and store them in the array
     */
    public function __call($method, $arguments)
    {
        if ($this->method == $method) {
            $this->routes[$arguments[0]] = $arguments[1];
        }
    }

    public function exec()
    {
        if (isset($this->routes[$this->action])) {
            call_user_func($this->routes[$this->action]);
        } else {
            throwException('ERR_INVALID_ROUTE');
        }
    }
}
