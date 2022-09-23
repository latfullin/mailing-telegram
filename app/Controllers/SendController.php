<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Services\Authorization\Telegram;

class SendController
{
  public function sendMessage(ArgumentsHelpers $arg)
  {
    Telegram::instance($arg->phone)->sendMessage($arg->how, $arg->msg);
  }
}
