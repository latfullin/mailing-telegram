<?php

namespace App\Routers;

use App\Middleware\Middleware;
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

    if (self::$instance[self::$url] ?? false && self::$instance[self::$url]->method == $method) {
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
      preg_match('/^\/api/', $url, $api);
      self::$instance[$url] = new self();
      self::$instance[$url]->method = $method;
      self::$instance[$url]->class = $class[0];
      self::$instance[$url]->function = $class[1];
      self::$instance[$url]->requestMethod = $api ? 'api' : 'web';
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
          $midl = new Middleware();
          foreach (self::$instance[$url]?->middleware as $middle) {
            Providers::call($midl->getMiddleware($middle), 'handle');
          }
        }
        $page = substr($url, 0) == '/' ? substr($url, 1) : $url;
        $data['page'] = $page == '/' || $page == '' ? 'home' : $page;
        self::handle($url, $data);
      } catch (Execute $e) {
        self::notFound();
      }
    } else {
      self::notFound();
    }
  }

  public static function handle(string $url, array $data = [])
  {
    Providers::call(self::$instance[$url]->class, self::$instance[$url]->function, [$_GET, $_POST, $data]);
  }

  public static function notFound()
  {
    Providers::call(\App\Controllers\ViewController::class, 'notFound', []);
  }

  public static function middleware(string|array $middleware)
  {
    if (is_array($middleware)) {
      foreach ($middleware as $midl) {
        self::$instance[self::$url]->middleware[] = $midl;
      }
    }
    if (is_string($middleware)) {
      self::$instance[self::$url]->middleware[] = $middleware;
    }

    return self::$instance[self::$url];
  }

  public static function getrequestMethod(string $url): ?string
  {
    return self::$instance[$url]->requestMethod ?? null;
  }
}
