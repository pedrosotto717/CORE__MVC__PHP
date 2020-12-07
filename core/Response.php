<?php

namespace app\core;

final class Response
{
    public static function statusCode(int $code)
    {
        http_response_code($code);
    }

    public static function redirect($url)
    {
        header("Location: $url");
    }
}
