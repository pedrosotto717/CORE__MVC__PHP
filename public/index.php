<?php

require_once __DIR__ . '/../core/Autoload.php';

use app\core\Application;
use app\core\Request;

// use function app\core\{Application, Request};
// use app\core\Application;


ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

var_dump(Request::getUrl());
echo "<br>";

$app = new Application();

$app->router->get("/", ["action" => "HOME"]);
$app->router->get("/contact", ["contactController", "index_action"]);

$app->router->get("/about", "ABOUT");

$app->router->get(
  [
    "path" => "/user/{id}",
    "regExp" => "\d+\Z"
  ],
  "ABOUT"
);



$app->run();

echo "
<br>
<br>
<br>
<br>
<br>
<hr>
<br>";

$lo_que_tengo = "/view/{v}#hola";
$lo_que_me_llega = "/view/1";

// "\D+\Z" NOT NUMBERS and endline
// "\d+\Z" NUMBERS and endline

$regExpr = "\d\Z";

if (preg_match("(\{)", $lo_que_tengo)) {
  echo "SI VAN A VENIR PARAMETROS";
  echo "<br><br>";
  $lo_que_tengo =  parse_url($lo_que_tengo, PHP_URL_PATH);
  var_dump($lo_que_tengo);
  echo "<br><br>";
  echo "<br><br>";


  $posStart = strpos($lo_que_tengo, "{");
  $posEnd = strlen($lo_que_tengo);

  $URL_Residente = substr($lo_que_tengo, $posStart, $posEnd);
  $URL_Residente = str_replace(["{", "}"], "", $URL_Residente);
  echo "JUST:: " . $URL_Residente;
  echo "<br><br>";

  $a = substr($lo_que_tengo, 0, $posStart);
  echo $a . "<br>";
  if (preg_match("((" . $a . ")" . $regExpr . ")", $lo_que_me_llega) === 1) {
    echo "TRUE_MATCH";
  }


  echo "<br><br>";
  echo $lo_que_me_llega;
}

echo "<br><hr>";

if (preg_match("((/user/)\d+\Z)", "/user/1") === 1) {
  echo "<br>TRUE<br>";
}

$url1 = parse_url("/contact/",PHP_URL_PATH);
$url1 = urldecode($url1);
$url1 = preg_replace("(()[\/]+\Z)", "", $url1);

$url2 = parse_url("/contact", PHP_URL_PATH);

echo "
<br>
<br>
<br>
";

var_dump($url1);
echo "
<br>
<br>
<br>
";
var_dump($url2);
