<?php

namespace app\core;

/**
 * $view = View::make("Home", ["title" => ""]); // return HTML put Not Render
 * View::render($view); // received HTML and render
 * 
 * View::renderView("Home", ["title" => ""]); // render file
 */

final class View
{
  public static string $path = "";

  /**
   * Init the config and other
   */
  public static function Init()
  {
    self::$path = Config::View("path");
  }


  /** 
   * make the view and return
   * @return string "HTML" 
   */
  public static function make(string $viewFile, array $params = []): ?string
  {
    $viewFile = self::makePath($viewFile);
    $viewFile = self::capture($viewFile, $params);
    $viewFile = self::replaceParams($viewFile, $params);

    return $viewFile;
  }


  /** 
   * make the view and render
   */
  public static function renderView(string $viewFile, array $params = []): void
  {
    $viewFile = self::make($viewFile, $params);
    self::render($viewFile);
  }


  /** 
   * render the view, Text how HTML or Array how JSON
   */
  public static function render($view): bool
  {
    if (is_string($view)) {
      Response::renderHTML($view);
    } elseif (is_array($view)) {
      Response::renderJson($view);
    } else return false;

    return true;
  }


  /**
   * make the path and replace '.' for '/'
   */
  private static function makePath(string $path): string
  {
    return self::$path . (string) str_replace(".", "/", $path);
  }

  /**
   * replace {{$key}} for $params["$key"]
   * @return string
   */
  private static function replaceParams(string $view, array $params = []): string
  {
    foreach ($params as $key => $value) {
      $view =  str_replace(
        ['{{ ' . $key . ' }}', '{{ $' . $key . ' }}', ' {{ $' . $key . ' }} ', ' {{ ' . $key . ' }} '],
        $value,
        $view
      );
    }
    return $view;
  }

  /**
   * get and return the view file
   */
  public static function capture(string $file, array $params = [])
  {

    extract($params, EXTR_SKIP);

    // Capture the view output
    ob_start();

    try {
      // Load the view within the current scope
      include $file . ".php";
    } catch (\Exception $e) {
      // Delete the output buffer
      ob_end_clean();
      return View::renderView("500");
    }

    // Get the captured output and close the buffer
    return ob_get_clean();
  }

  /**
   * this function make tags script
   *
   * @param array $files array (list scripts)
   * @return string
   **/
  public static function makeScripts(array $files): string
  {
    $tags = "";

    foreach ($files as $key) {
      $tags .= "<script src='js/{$key}.js'></script>";
    }

    return $tags ?? "";
  }

  /**
   * this function make tags style
   *
   * @param array $files array (list scripts)
   * @return string
   **/
  public static function makeStyles(array $files): string
  {
    $tags = "";

    foreach ($files as $key) {
      $tags .= "<link rel='stylesheet' href='css/{$key}.css'>";
    }

    return $tags ?? "";
  }
}
