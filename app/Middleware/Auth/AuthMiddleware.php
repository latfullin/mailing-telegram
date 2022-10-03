<?php

namespace App\Middleware\Auth;

use App\Contracts\Middleware\Middleware;

class AuthMiddleware implements Middleware
{
  private ?array $session = null;
  private ?array $cokkie = null;
  public function __construct()
  {
    $this->session = $_SESSION;
    $this->cokkie = $_COOKIE;
  }

  public function handle()
  {
    if ($this->session['auth'] !== true) {
      header('Location: /login');
      exit();
    }

    return true;
  }
}
