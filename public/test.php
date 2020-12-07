<?php

$params = ["title" => "PICTUNEX"];
extract($params, EXTR_SKIP);

ob_start();
include "./test.php";
$html = ob_get_clean();


// $html2 = file_get_contents("./test.php", FILE_USE_INCLUDE_PATH);

$html2 = print_r($html, true);
$html2 = $html;


foreach ($params as $key => $value) {
  $html2 =  str_replace(['{{ ' . $key . ' }}', '{{ $' . $key . ' }}', ' {{ $' . $key . ' }} ', ' {{ ' . $key . ' }} '], $value,  $html2);
}

echo $html2;
