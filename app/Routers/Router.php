<?php

namespace App\Routers;

use App\Models\PagesModel;
use App\Providers\Providers;

class Router
{
  private static PagesModel $layout;
  private static $web = [];
  private static $post = [];
  public static function start(string $url, string $method)
  {
    $url = strtok($url, '?');
    if ($method == 'POST') {
      self::postValidate($url);
    }
    if ($method == 'GET') {
      $params = self::getLayout($url, $method);
      include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/layouts/{$params}.php";
    }
  }

  public static function getLayout($url, $method)
  {
    $pages = new PagesModel();
    $params = $pages->where(['page' => $url, 'method' => $method])->first();
    return $params ? $params['layout'] : '404';
  }

  public static function getRoute()
  {
    print_r(self::$web);
  }

  public static function get($url, $class)
  {
    self::$web[$url] = $class;
  }

  public static function post($url, $class)
  {
    self::$post[$url] = $class;
  }

  public static function getValidate($url)
  {
    print_r(self::$post);
  }

  public static function postValidate($url)
  {
    if (self::$post[$url] ?? false) {
      new Providers(self::$post[$url][0], self::$post[$url][1], [$_GET, $_POST]);
    } else {
      include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/layouts/404.php";
    }
  }
}
