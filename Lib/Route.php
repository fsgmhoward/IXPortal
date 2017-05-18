<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

use Closure;

class Route
{
    protected $routes = array();
    protected $prefix = array();
    protected $middleware = array(
        'all'     => array(),
        'default' => array()
    );
    protected $method;
    protected $action;
    protected $defaultGroup = 'default';

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
    public function regMiddleware($group, $func)
    {
        if (!isset($this->middleware[$group])) {
            $this->middleware[$group] = array();
        }
        $this->middleware[$group][] = $func;
        return $this;
    }

    /*
     * Register a prefix
     */
    public function regPrefix($method, $prefix, $function, $group = null)
    {
        if ($this->method == $method) {
            $this->prefix[] = array($prefix, $function, $group ?: $this->defaultGroup);
        }
        return $this;
    }

    /*
     * Register a group of requests
     */
    public function group($group, Closure $groupedRoutes, $groupMiddleware = array()) {
        $this->defaultGroup = $group;
        $groupedRoutes($this);
        $this->defaultGroup = 'default';
        if ($groupMiddleware) {
            if (isset($this->middleware[$group])) {
                $this->middleware[$group] = array_merge($this->middleware[$group], $groupMiddleware);
            } else {
                $this->middleware[$group] = $groupMiddleware;
            }
        }
        return $this;
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
            $this->routes[$arguments[0]] = array($arguments[1], isset($arguments[2]) ? $arguments[2] : $this->defaultGroup);
        }
        return $this;
    }

    public function exec()
    {
        foreach ($this->prefix as $prefix) {
            if (strpos($this->action, $prefix[0]) === 0) {
                // Execute middleware for all request
                foreach ($this->middleware['all'] as $middleware) {
                    self::call($middleware);
                }
                // Execute middleware for grouped request
                foreach ($this->middleware[$prefix[2]] as $middleware) {
                    self::call($middleware);
                }
                self::call($prefix[1]);
                return;
            }
        }
        if (isset($this->routes[$this->action])) {
            // Execute middleware for all request
            foreach ($this->middleware['all'] as $middleware) {
                self::call($middleware);
            }
            // Execute middleware for grouped request
            foreach ($this->middleware[$this->routes[$this->action][1]] as $middleware) {
                self::call($middleware);
            }
            // Execute user function
            self::call($this->routes[$this->action][0]);
        } else {
            throwException('ERR_INVALID_ROUTE');
        }
    }

    protected static function call($callback)
    {
        if (is_callable($callback)) {
            call_user_func($callback);
        } else {
            throwException('ERR_INVALID_CALLBACK');
        }
    }
}
