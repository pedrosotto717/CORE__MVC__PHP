<?php

namespace app\core;

use app\controllers\HomeController;

/**
 * The Router's Class
 */
final class Router
{
    private static array $map = [];
    private string $method;
    private string $url;
    private $routeMatch = null;

    public function __construct(string $method, string $url)
    {
        $this->method = $method;
        $this->url = $url;
    }

    /**
     * Defined and storage Routes into the map_routes if REQUEST_METHOD === GET  
     **/
    public function get($url, $actionController): void
    {
        self::$map['get'][] = new Route($url, $actionController);
    }

    /**
     * Defined and storage Routes into the map_routes if REQUEST_METHOD === POST  
     **/
    public function post($url, $actionController): void
    {
        self::$map['post'][] = new Route($url, $actionController);
    }


    /**
     * Defined and storage Routes into the map_routes if REQUEST_METHOD === PUT  
     **/
    public function put($url, $actionController): void
    {
        self::$map['put'][] = new Route($url, $actionController);
    }

    /**
     * Defined and storage Routes into the map_routes if REQUEST_METHOD === DELETE  
     **/
    public function delete($url, $actionController): void
    {
        self::$map['delete'][] = new Route($url, $actionController);
    }

    /**
     * return true if match map_route 
     */
    public function match(): bool
    {

        if (is_null($this->routeMatch)) {
            foreach (self::$map[$this->method] as $index => $Route) {
                if ($Route->match($this->url)) {
                    $this->routeMatch = &$Route;
                    return true;
                }
            }
        } elseif ($this->routeMatch instanceof Route) {
            return true;
        }
        return false;
    }

    /**
     * Resolve the routes and return a action
     **/
    public function resolve()
    {
        if ($this->match()) {
            return $this->routeMatch;
        }

        return false;
    }
}
