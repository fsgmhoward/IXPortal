<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

use Closure;

class Route
{
    protected $routes = array(
        'all' => array(),
        'get' => array(),
        'post' => array()
    );
    protected $prefix = array(
        'all' => array(),
        'get' => array(),
        'post' => array()
    );
    protected $delayedPrefix = array(
        'all' => array(),
        'get' => array(),
        'post' => array()
    );
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
        if (!(($this->method = strtolower($_SERVER['REQUEST_METHOD'])) != 'get' || $this->method != 'post')) {
            throwException('ERR_METHOD_UNSUPPORTED');
        }
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
    public function regPrefix($method, $prefix, $function, $group = null, $delay = false)
    {
        if ($delay) {
            $this->prefix[$method][] = array($prefix, $function, $group ?: $this->defaultGroup);
        } else {
            $this->delayedPrefix[$method][] = array($prefix, $function, $group ?: $this->defaultGroup);
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
        $this->routes[$method][$arguments[0]] = array($arguments[1], isset($arguments[2]) ? $arguments[2] : $this->defaultGroup);
        return $this;
    }

    /*
     * Execution Sequence (from specific method to `all`):
     * - Prefixes
     * - Specific Routes
     * - Delayed Prefixes
     */
    public function exec()
    {
        $prefixes = array_merge($this->prefix[$this->method], $this->prefix['all']);
        foreach ($prefixes as $prefix) {
            if (strpos($this->action, $prefix[0]) === 0) {
                // Execute all executables (`all` first, specific ones later, main function last)
                $executables = array_merge($this->middleware['all'], $this->middleware[$prefix[2]], array($prefix[1]));
                foreach ($executables as $executable) {
                    self::call($executable);
                }
                return;
            }
        }
        // Specific Method behind `all` ones so it can overwrite if the same key route exists
        $specificRoutes = array_merge($this->routes['all'], $this->routes[$this->method]);
        if (isset($specificRoutes[$this->action])) {
            $executables = array_merge(
                $this->middleware['all'],
                $this->middleware[$specificRoutes[$this->action][1]],
                array($specificRoutes[$this->action][0])
            );
            foreach ($executables as $executable) {
                self::call($executable);
            }
            return;
        }
        $delayedPrefixes = array_merge($this->delayedPrefix[$this->method], $this->delayedPrefix['all']);
        foreach ($delayedPrefixes as $delayedPrefix) {
            if (strpos($this->action, $delayedPrefix[0]) === 0) {
                // Execute all executables (`all` first, specific ones later, main function last)
                $executables = array_merge(
                    $this->middleware['all'],
                    $this->middleware[$delayedPrefix[2]],
                    array($delayedPrefix[1])
                );
                foreach ($executables as $executable) {
                    self::call($executable);
                }
                return;
            }
        }
        throwException('ERR_INVALID_ROUTE');
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
