<?php

namespace App\Helpers\Sessions;

class Session
{
  protected ?array $session = null;
  protected ?Session $instance = null;
  public function __construct()
  {
    $this->instance = $this;
  }

  public function handle()
  {
    if (!isset($_SESSION)) {
      session_start();
      $this->session = &$_SESSION;
      if (empty($_SESSION['auth'])) {
        $_SESSION['auth'] = false;
      }
      if (empty($_SESSION['is_admin'])) {
        $_SESSION['is_admin'] = false;
      }
    }
  }
}
