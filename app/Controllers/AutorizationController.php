<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;

class AutorizationController
{
  private $createSession = false;
  public function createSession(ArgumentsHelpers $argumets, PhoneModel $phone)
  {
    try {
      if (!$this->createSession) {
        $findSession = $phone->where(["phone" => $argumets->phone])->first();
        if (empty($findSession)) {
          $phone->insert(["phone" => $argumets->phone]);
        }
        $this->createSession = true;
        $telegram = Telegram::instance($argumets->phone);
      }

      $telegram->sendMessage("@hitThat", "{$argumets->phone}");
    } catch (\Exception $e) {
      print_r($e);
      echo "error";
    }
  }
}
