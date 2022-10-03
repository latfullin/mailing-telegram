<?php

namespace App\Helpers\Sessions;

class Session
{
  protected ?array $session = null;
  protected static ?Session $instance = null;
  public function __construct()
  {
  }

  public function handle()
  {
    if (!isset($_SESSION)) {
      session_start();
      self::$instance = $this;
      $this->session = &$_SESSION;
      if (empty($_SESSION['auth'])) {
        $_SESSION['auth'] = false;
      }
      if (empty($_SESSION['is_admin'])) {
        $_SESSION['is_admin'] = false;
      }
      if (empty($_SESSION['access'])) {
        $_SESSION['access'] = 0;
      }
    }
  }

  public static function intance()
  {
    if (isset(self::$instance)) {
      return self::$instance;
    }
    return new self();
  }

  public function getAuth()
  {
    return $this->session['auth'];
  }

  public function getAccess()
  {
    return $this->session['access'];
  }

  public function get($key)
  {
    return $this->session[$key] ?? null;
  }
}
