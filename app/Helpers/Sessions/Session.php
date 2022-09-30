<?php

namespace App\Helpers\Sessions;

class Session
{
  protected static ?array $session = null;

  public function __construct()
  {
  }

  public function handle()
  {
    if (!isset($_SESSION)) {
      session_start();
      self::$session = &$_SESSION;
      if (empty($_SESSION['auth'])) {
        $_SESSION['auth'] = false;
      }
      if (empty($_SESSION['is_admin'])) {
        $_SESSION['is_admin'] = false;
      }
    }
  }
}
