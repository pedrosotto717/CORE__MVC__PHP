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
            $this->router->resolve();
            if ($this->router->match()) {
                $action = $this->router->resolve();

                if (is_array($action)) {
                    var_dump($action); // return [Controller::method, URI_PARAMS]
                } elseif (is_string($action)) {
                    echo $action;
                } elseif (is_callable($action)) {
                    echo call_user_func($action);
                } else {
                    throw new \Exception("Error Processing Request", 1);
                }

            } else {
                //NOT_FOUND
                echo "NOT_FOUND";
            }
        } catch (\Exception $ex) {
            echo "500 SERVER_ERROR";
        }
    }
}
