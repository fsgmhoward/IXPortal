<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Route
{
    protected $routes = array();
    protected $middleware = array(
        'all'     => array(),
        'default' => array()
    );
    protected $method;
    protected $action;

    public static $currentAction;

    public function __construct()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $requestURI = strtok($_SERVER['REQUEST_URI'], '?');
        if (isset($_GET['action']) && $_GET['action'] !== '') {
            $this->action = $_GET['action'];
        } elseif ($requestURI != '/' &&
            strpos($requestURI, '.php') === false){
            // If .php is not in REQUEST_URI, the request should have been rewritten
            $this->action = substr($requestURI, 1);
        } else {
            $this->action = 'index';
        }
        self::$currentAction = $this->action;
    }

    /*
     * Register group middleware (executed before call user function)
     */
    public function regMiddleware($group, $func) {
        if (!isset($this->middleware[$group])) {
            $this->middleware[$group] = array();
        }
        $this->middleware[$group][] = $func;
    }

    /*
     * Register route and store them in the array
     * arguments[0] - route name / action
     * arguments[1] - class name / closure
     * arguments[2] - group name - default: 'default'
     */
    public function __call($method, $arguments)
    {
        if ($this->method == $method) {
            $this->routes[$arguments[0]] = array($arguments[1], isset($arguments[2]) ? $arguments[2] : 'default');
        }
    }

    public function exec()
    {
        if (isset($this->routes[$this->action])) {
            // Execute middleware for all request
            foreach ($this->middleware['all'] as $middleware) {
                call_user_func($middleware);
            }
            // Execute middleware for grouped request
            foreach ($this->middleware[$this->routes[$this->action][1]] as $middleware) {
                call_user_func($middleware);
            }
            // Execute user function
            call_user_func($this->routes[$this->action][0]);
        } else {
            throwException('ERR_INVALID_ROUTE');
        }
    }
}
