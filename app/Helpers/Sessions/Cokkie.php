<?php

namespace App\Helpers\Sessions;

class Cokkie
{
  public function __construct()
  {
  }

  public function handle()
  {
    if (empty($_COOKIE['token']) || empty($_SESSION['token'])) {
      $token = $this->getToken();
      $time = time() + 60 * 60;
      setcookie('token', $token, $time);
      $_SESSION['token']['token'] = $token;
      $_SESSION['token']['time'] = $time;
    }
  }

  public function getToken()
  {
    $generate = $this->generateToken();
    return md5($generate);
  }

  private function generateToken()
  {
    $str = '';
    $len = mt_rand(500, 1000);
    for ($i = 1; $i < $len; $i++) {
      $str .= rand(round($i * 1.25), round($i * 2.5));
    }

    return $str;
  }
}
