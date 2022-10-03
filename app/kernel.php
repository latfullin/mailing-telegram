<?php

namespace App;

class kernel
{
  protected array $services = [
    'web' => [
      'sessions' => \App\Helpers\Sessions\Session::class,
      'cokkie' => \App\Helpers\Sessions\Cokkie::class,
      'access' => \App\Helpers\Access::class,
    ],
    'api' => [
      'sessions' => \App\Helpers\Sessions\Session::class,
      'cokkie' => \App\Helpers\Sessions\Cokkie::class,
    ],
  ];
}
