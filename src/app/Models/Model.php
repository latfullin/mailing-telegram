<?php

namespace App\Models;

use MySQLi;

class Model
{
  protected $dsn;

  public static function connect()
  {
    $dsn = 'http://127.0.0.1/';
    $user = 'root';
    $password = '';
    new MySQLi($dsn, $user, $password, 'telegram_bot');
  }
}
