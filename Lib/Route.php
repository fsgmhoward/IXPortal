<?php
/*
 * IX Framework - A Simple MVC Framework
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
        if (isset($_GET['action']) && $_GET['action'] !== '') {
            $this->action = $_GET['action'];
        } elseif ($_SERVER['REQUEST_URI'] != '/' &&
            strpos($_SERVER['REQUEST_URI'], '.php') === false){
            // If .php is not in REQUEST_URI, the request should have been rewritten
            $this->action = substr($_SERVER['REQUEST_URI'], 1);
        } else {
            $this->action = 'index';
        }
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
