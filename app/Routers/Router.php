<?php

namespace App\Routers;

use App\Models\PagesModel;
use App\Providers\Providers;
use App\Services\Executes\Execute;

class Router
{
  private static $get = [];
  private static $url = '';
  private static $instance = [];
  public static function start(string $url, string $method)
  {
    self::$url = strtok($url, '?');
    if (self::$instance[$url] ?? false && self::$instance[$url]->method == $method) {
      self::providers(self::$url);
    } else {
      self::notFound();
    }
  }

  public static function getLayout(string $url, string $method)
  {
    $pages = new PagesModel();
    $params = $pages->where(['page' => $url, 'method' => $method])->first();
    return $params ? $params : '404';
  }

  public static function getUrl()
  {
    return self::$get[self::$url];
  }

  public static function get(string $url, array $class)
  {
    return self::instance($url, $class, 'get');
  }

  private static function instance(string $url, array $class, string $method)
  {
    if (!isset(self::$instance[$url])) {
      self::$instance[$url] = new self();
      self::$instance[$url]->method = $method;
      self::$instance[$url]->class = $class[0];
      self::$instance[$url]->function = $class[1];
      self::$url = $url;
      return self::$instance[$url];
    }
    return self::$instance[$url];
  }

  public static function post(string $url, $class)
  {
    return self::instance($url, $class, 'post');
  }

  public static function providers($url, array $data = [])
  {
    if (self::$instance[$url] ?? false) {
      try {
        if (self::$instance[$url]?->middleware ?? false) {
          self::handle($url, self::$instance[$url]->middleware);
        }
        $page = substr($url, 0) == '/' ? substr($url, 1) : $url;
        $data['page'] = $page == '/' || $page == '' ? 'home' : $page;
        new Providers(self::$instance[$url]->class, self::$instance[$url]->function, [$_GET, $_POST, $data]);
      } catch (Execute $e) {
        self::notFound();
      }
    } else {
      self::notFound();
    }
  }

  public static function handle(string $url, string $middleware)
  {
    if ($_SESSION['is_admin'] === true) {
      return true;
    }
    self::notFound();
  }

  public static function notFound()
  {
    view('default', ['page' => 404], 404);
    exit();
  }

  public static function middleware($middleware)
  {
    self::$instance[self::$url]->middleware = $middleware;

    return self::$instance[self::$url];
  }
}
