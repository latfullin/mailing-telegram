<?php

namespace App\Routers;

use App\Models\PagesModel;
use App\Providers\Providers;
use App\Services\Executes\Execute;

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
      if (self::$web[$url] ?? false) {
        self::webValidate(self::$url);
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

  public static function postValidate($url, array $data = [])
  {
    if (self::$post[$url] ?? false) {
      try {
        new Providers(self::$post[$url][0], self::$post[$url][1], [$_GET, $_POST, $data]);
      } catch (Execute $e) {
        self::notFound();
      }
    } else {
      self::notFound();
    }
  }

  public static function webValidate($url, array $data = [])
  {
    if (self::$web[$url] ?? false) {
      $data['page'] = substr($url, 0) == '/' ? substr($url, 1) : $url;
      new Providers(self::$web[$url][0], self::$web[$url][1], [$_GET, $_POST, $data]);
    } else {
      self::notFound();
    }
  }

  public static function notFound()
  {
    view('default', ['page' => 404], 404);
  }
}
