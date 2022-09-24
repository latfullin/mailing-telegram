<?php

namespace App\Routers;

use App\Models\PagesModel;
use App\Providers\Providers;

class Router
{
  private static PagesModel $layout;
  private static $web = [];
  private static $post = [];
  private static $url = '';
  public static function start(string $url, string $method)
  {
    self::$url = strtok($url, '?');
    if ($method == 'POST') {
      self::postValidate(self::$url);
      return;
    }
    if ($method == 'GET') {
      $params = self::getLayout(self::$url, $method);
      if ($params != '404') {
        $page = substr($params['page'], 0) == '/' ? substr($params['page'], 1) : $params['page'];
        include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/components/layouts/{$params['layout']}.php";
      } else {
        self::notFound();
      }
    }
  }

  public static function getLayout($url, $method)
  {
    $pages = new PagesModel();
    $params = $pages->where(['page' => $url, 'method' => $method])->first();
    return $params ? $params : '404';
  }

  public static function getUrl()
  {
    return self::$web[self::$url];
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
      return new Providers(self::$post[$url][0], self::$post[$url][1], [$_GET, $_POST]);
    } else {
      self::notFound();
    }
  }
  public static function notFound()
  {
    include_once "{$_SERVER['DOCUMENT_ROOT']}/resources/components/layouts/404.php";
  }
}
