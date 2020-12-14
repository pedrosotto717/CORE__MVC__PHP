<?php

require_once __DIR__ . '/../core/Autoload.php';

use app\core\Config;
use app\core\Application;
use app\core\View;

// setting ERRORS' Message
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

// Inits
Config::Init();
View::Init();

$app = new Application();

$app->router->get("/", [\app\controllers\HomeController::class,"index"]);

$app->router->get("/contact", function($params){
  return View::render("<h1>/contact ??</h1>");
});

$app->router->get("/productos", function($params){
  return "estoy en productos";
});

$app->router->get(
  [
    "path" => "/user/{id}",
    "regExp" => "\d+\Z"
  ],
  function($params){
    return "USERS -> " . $params["id"];
  }
);

$app->run();
