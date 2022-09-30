<?php

namespace App\Middleware;

class Middleware
{
  protected $middleware = [
    'auth' => \App\Middleware\Auth\AuthMiddleware::class,
    'isAdmin' => \App\Middleware\Auth\IsAdminMiddleware::class,
  ];

  public function getMiddleware($middleware)
  {
    return $this->middleware[$middleware];
  }
}
