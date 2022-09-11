<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Services\Authorization\TelegramAuthorization;

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
        $telegram = new TelegramAuthorization(
          $argumets->phone,
          $argumets->proxy
        );
      }

      $telegram->autorizationSession(
        "{$argumets->phone}  privated my s toboy "
      );
    } catch (\Exception $e) {
      print_r($e);
      // $telegram->autorizationSession("My fristasd sas");
      echo "error";
    }
  }
}
