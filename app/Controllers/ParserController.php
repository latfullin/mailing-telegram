<?php

namespace App\Controllers;

use App\Services\Bot\TelegramBot;
use App\Services\Executes\ParserExecute;
use App\Services\Executes\ParserTelephoneExecute;

class ParserController
{
  public function checkPhone(array|object $phones): void
  {
    $parser = new ParserTelephoneExecute(false, true);
    $filePath = $parser
      ->checkPhones($phones)
      ->usersProcessing()
      ->save();
  }

  public function parseGroup(
    $arg,
    ParserExecute $parser,
    TelegramBot $telegram
  ): void {
    $filePath = $parser
      ->channel($arg->channel)
      ->executes()
      ->save();
    // $telegram->setChatId("45881581")->sendFile($filePath);
    $telegram->setChatId("365047507")->sendFile($filePath);
  }
}
