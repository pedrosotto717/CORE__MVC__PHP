<?php

namespace app\core;

final class Config
{
  private static string $ROOT_DIR = "";
  private static array $APP = [];
  private static array $VIEW = [];

  public static function Init(): void
  {
    self::$ROOT_DIR = (string) dirname(__DIR__);

    self::$APP = [];

    // Init Config For View
    self::$VIEW = [
      "path" => self::$ROOT_DIR . "/views/"
    ];
  }

  public static function View(string $key): string
  {
    return self::$VIEW["path"];
  }
}
