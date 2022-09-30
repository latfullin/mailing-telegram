<?php

namespace App;

class kernel
{
  protected array $services = [
    'sessions' => \App\Helpers\Sessions\Session::class,
    'cokkie' => \App\Helpers\Sessions\Cokkie::class,
  ];
}
