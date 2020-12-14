<?php

namespace app\controllers;

use app\core\Controller;
use app\core\View;

final class HomeController extends Controller
{
  private array $params = [];

  public function __construct()
  {
    parent::__construct();

    $this->params = [
      "title" => "Pictunex",

      "styles" => View::makeStyles([
        "main"
      ]),

      "scripts" => View::makeScripts([
        "main"
      ]),

      "footer" => View::make("components.footer")
    ];
  }

  public function index($uriParams = null): void
  {
    $params = [
      "mainContent" => View::make("home", $this->params)
    ];

    $this->params = array_merge($this->params, $params);

    View::renderView("components.main", $this->params);
  }
}
