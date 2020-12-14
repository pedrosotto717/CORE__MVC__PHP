<?php


namespace app\core;


/**
 * HandlerRoute 
 */
final class Route
{

  /** @var string $URI  */
  private $URI = "";

  /** 
   * 
   *  The action, controller, callable, closure, etc. this route points to.
   *  @var mixed 
   **/
  private $handler = null;

  /**
   * 
   *  real url
   *  example: "/productos/search" or "/home"
   *  @var string $url 
   * 
   */
  private string $url;


  /**
   * 
   *  the fullUri_Param 
   *  example: "user/delete/{id}"
   *  @var string $fullPath_RegExp 
   * 
   */
  private ?string $fullPath_RegExp = null;

  /**
   *  Regular Expression for mathes whith the url_param
   *  example "/user/delete/{id}" -> {id} /\d\Z/ (Only Numbers and endLine)
   *  @var string $regExp
   * 
   */
  private string $regExp = "";

  /**
   *  Params of the Request::URL
   *  @var array $uriParams
   * 
   */
  private array $uriParams = [];


  /**
   * * @param string|array $uri
   * if is_array [
   *  "path" => string
   *  "regExp" => string
   * ]
   * 
   * * @param string|array|callback|closure $handler
   */
  public function __construct($uri, $handler)
  {
    if (is_array($uri)) {
      $this->url = $uri["path"];
      $this->regExp = $uri["regExp"];

      $posStart = strpos($this->url, "{");
      $posEnd = strlen($this->url);

      $path_param = substr($this->url, $posStart, $posEnd);
      $path_param = str_replace(["{", "}"], "", $path_param);
      $this->uriParams[$path_param] = null;

      $this->fullPath_RegExp = substr($this->url, 0, $posStart);
      $this->URI =  $this->fullPath_RegExp;
      $this->fullPath_RegExp = "((" . $this->fullPath_RegExp . ")" . $this->regExp . ")";
    } elseif (is_string($uri)) {
      $this->url = $uri;
    }

    $this->handler = $handler;
  }

  public function url(): string
  {
    return $this->url;
  }


  public function handler()
  {
    return $this->handler;
  }


  public function fullRegExp(): ?string
  {
    return $this->fullPath_RegExp ?? null;
  }

  public function regExp(): string
  {
    return $this->regExp;
  }

  public function params(): array
  {
    return $this->uriParams;
  }

  public function match($url)
  {
    if (is_null($this->fullRegExp())) {

      return strcasecmp(
        $this->cleanURI($url),
        $this->cleanURI($this->url)
      ) === 0 ? true : false;
    } else {

      $this->extractParams($url);
      return preg_match($this->fullRegExp(), $this->cleanURI($url)) ? true : false;
    }
  }

  private function cleanURI($url): string
  {
    if ($url === "/") {
      return $url;
    } else return preg_replace(
      "(()[\/]+\Z)", // pattern
      "", // replacement
      urldecode( // subject
        parse_url($url, PHP_URL_PATH)
      )
    );
  }

  private function extractParams($url): void
  {
    $url = preg_replace("({$this->URI})", "", $url);

    foreach ($this->uriParams as $key => $value) {
      $this->uriParams[$key] = $url;
    }
  }
}
