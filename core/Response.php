<?php

namespace app\core;

final class Response
{
    public static function statusCode(int $code): void
    {
        http_response_code($code);
    }

    public static function redirect($url): void
    {
        header("Location: $url");
    }

    public static function renderHTML(string $view): void
    {
        self::setHeaders("Content-Type", "text/html; charset=UTF-8");
        echo $view;
    }

    public static function renderJson(array $array = []): void
    {
        self::setHeaders("Content-Type", "application/json");
        echo json_encode($array);
    }

    public static function setHeaders($key, $value): void
    {
        header("{$key}: {$value}");
    }
}
