<?php


namespace app\core;


/**
 * HandlerRoute 
 */
class Route
{

  /** @var string $URI  */
  protected $URI = "";

  /** 
   * 
   *  The action, controller, callable, closure, etc. this route points to.
   *  @var mixed 
   **/
  public $handler = null;

  /**
   * 
   *  real url
   *  example: "/productos/search" or "/home"
   *  @var string $url 
   * 
   */
  public string $url;


  /**
   * 
   *  the fullUri_Param 
   *  example: "user/delete/{id}"
   *  @var string $fullPath_RegExp 
   * 
   */
  public ?string $fullPath_RegExp = null;

  /**
   *  Regular Expression for mathes whith the url_param
   *  example "/user/delete/{id}" -> {id} /\d\Z/ (Only Numbers and endLine)
   *  @var string $regExp
   * 
   */
  public string $regExp = "";

  /**
   *  Params of the Request::URL
   *  @var array $uriParams
   * 
   */
  public array $uriParams = [];


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


  public function fullRegExp(): ?string
  {
    return $this->fullPath_RegExp ?? null;
  }

  public function match($url)
  {
    // var_dump($this->uriParams);
    if (is_null($this->fullRegExp())) {

      return strcasecmp(
        $this->cleanURI($url),
        $this->cleanURI($this->url)
      ) === 0 ? true : false;
    } else {

      $this->extractParams($url);
      var_dump($this);
      return preg_match($this->fullRegExp(), $this->cleanURI($url)) ? true : false;
    }
  }

  public function cleanURI($url): string
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

  public function extractParams($url): void
  {
    $url = preg_replace("({$this->URI})", "", $url);

    foreach ($this->uriParams as $key => $value) {
      $this->uriParams[$key] = $url;
    }
  }
}
