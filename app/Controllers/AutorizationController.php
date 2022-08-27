<?php

namespace App\Controllers;

use App\Services\Authorization\Telegram;

class AutorizationController
{
  public function createSession(string $phone)
  {
    Telegram::instance($phone)->autorizationSession();
  }
}
