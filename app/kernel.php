<?php

namespace App;

class kernel
{
  protected array $services = [
    'web' => [
      'sessions' => \App\Helpers\Sessions\Session::class,
      'cookie' => \App\Helpers\Sessions\Cookie::class,
      'access' => \App\Helpers\Access::class,
    ],
    'api' => [
      'sessions' => \App\Helpers\Sessions\Session::class,
      'cookie' => \App\Helpers\Sessions\Cookie::class,
    ],
  ];
}
