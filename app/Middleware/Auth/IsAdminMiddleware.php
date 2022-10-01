<?php

namespace App\Middleware\Auth;

class IsAdminMiddleware
{
  private ?array $session = null;
  public function __construct()
  {
    $this->session = $_SESSION;
  }

  public function handle()
  {
    if ($this->session && $this->session['is_admin'] === true) {
      return true;
    }
    header('Location: /home');
    exit();
  }
}
