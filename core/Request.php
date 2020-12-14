<?php

namespace app\core;

final class Request
{
    public static function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function getUrl(): string
    {
        return urldecode(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        );
    }

    public static function isGet(): bool
    {
        return self::getMethod() === 'get';
    }

    public static function isPost(): bool
    {
        return self::getMethod() === 'post';
    }

    public static function getBody(): array
    {
        $data = [];

        if (self::isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if (self::isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }

    //  getJson
}
