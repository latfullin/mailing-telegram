<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Services\Authorization\Telegram;

class SendController
{
  public function sendMessage(ArgumentsHelpers $arg)
  {
    try {
      Telegram::instance($arg->phone)->sendMessage($arg->how, $arg->msg);

      return response('Success send msg');
    } catch (\Exception $e) {
      return response('Error send message', status: 404);
    }
  }
}
