<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;

class AutorizationController
{
  public function createSession(PhoneModel $phone, ArgumentsHelpers $argumets)
  {
    $findSession = $phone->where(["phone" => $argumets->phone])->first();

    if (empty($findSession)) {
      $phone->insert(["phone" => $argumets->phone]);
    }

    Telegram::instance($argumets->phone)->autorizationSession();
  }
}
