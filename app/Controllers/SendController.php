<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Services\Authorization\Telegram;

class SendController
{
  public function sendMessage(ArgumentsHelpers $arg)
  {
    $this->startClient($arg->phone);
    try {
      $result = Telegram::instance($arg->phone)?->sendMessage($arg->how, $arg->msg);
      if ($result) {
        return response('Success send msg');
      }
      return response(
        'Number doesn\'t exist! Need phone authorization or write admin, all contacts find in page contacts\'!',
      );
    } catch (\Exception $e) {
      return response('Error send message', status: 404);
    }
  }

  public function startClient(...$phones)
  {
    foreach ($phones as $phone) {
      try {
        Telegram::instance($phone);
      } catch (\Exception $e) {
        continue;
      }
    }
  }
}
