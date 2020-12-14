<?php

namespace app\core;

class Application
{
    public Router $router;

    function __construct()
    {
        $this->router = new Router(Request::getMethod(), Request::getUrl());
    }

    public function run()
    {
        try {

            if ($this->router->match()) {
                $route = $this->router->resolve();
                $action = $route->handler();

                if (is_array($action)) {

                    $controller = new $action[0];
                    $method_action = (string) $action[1];

                    $controller->{$method_action}($route->params());
                } elseif (is_string($action)) {

                    View::renderView($action);
                } elseif (is_callable($action)) {
                    $res = call_user_func($action, $route->params());

                    if (is_string($res) || is_array($res)) {
                        View::render($res);
                    }
                } else {
                    throw new \Exception("Error Processing Request", 1);
                }
            } else {
                View::renderView("400");
            }
        } catch (\Exception $ex) {
            View::renderView("500");
        }
    }
}
