<?php

namespace app\core;


/**
 * The Router's Class
 */
class Router
{
    private static array $map = [];
    private string $method;
    private string $url;

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
        echo "<br><br>";
        // var_dump(self::$map['get']);

        // echo "<br><br>";
        // var_dump(self::$map['get'][3]);
        // echo "<br><br><br>______________";
        // foreach (self::$map['get'] as $key => $value) {
        //     var_dump($key->fullRegExp());
        // }
        /* if (preg_match(
            self::$map['get'][3]->fullRegExp(),
            $this->url
        ) === 1) {
            echo "<h1>TRUE_MATHES</h1>";
        } */
        // self::$map['get'][$url] = $actionController;
    }

    /**
     * Defined and storage Routes into the map_routes if REQUEST_METHOD === POST  
     **/
    public function post($url, $actionController): void
    {
        self::$map['post'][$url] = $actionController;
    }


    /**
     * Defined and storage Routes into the map_routes if REQUEST_METHOD === PUT  
     **/
    public function put($url, $actionController): void
    {
        self::$map['put'][$url] = $actionController;
    }

    /**
     * Defined and storage Routes into the map_routes if REQUEST_METHOD === DELETE  
     **/
    public function delete($url, $actionController): void
    {
        self::$map['delete'][$url] = $actionController;
    }

    /**
     * return true if match map_route 
     */
    public function match(): bool
    {
        return isset(self::$map[$this->method][$this->url]) ? true : false;
    }

    /**
     * Resolve the routes and return a action
     **/
    public function resolve()
    {
        // return self::$map[$this->method][$this->url] ?? false;
        foreach (self::$map[$this->method] as $index => $Route) {
            if($Route->match($this->url)){
                echo "<h1>TODO OK PARA LA RUTA::  {$Route->url()} </h1>";
            }
        }
    }
}
