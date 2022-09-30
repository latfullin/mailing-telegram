<?php

namespace App\Middleware\Auth;

class AuthMiddleware
{
  private ?array $session = null;
  public function __construct()
  {
    $this->session = $_SESSION;
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
