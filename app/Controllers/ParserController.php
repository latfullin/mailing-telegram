<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Services\Bot\TelegramBot;
use App\Services\Executes\ParserExecute;
use App\Services\Executes\ParserTelephoneExecute;

class ParserController
{
  public function checkPhone(
    ArgumentsHelpers $arg,
    ParserTelephoneExecute $parser,
    TelegramBot $telegram
  ): void {
    $filePath = $parser
      ->checkPhones($arg->phones)
      ->usersProcessing()
      ->save();
    $telegram->setChatId($arg->userId)->sendFile($filePath);
  }

  public function parseGroup(
    ArgumentsHelpers $arg,
    ParserExecute $parser,
    TelegramBot $telegram
  ): void {
    $filePath = $parser
      ->channel($arg->channel)
      ->executes()
      ->save();

    $telegram->setChatId($arg->userId)->sendFile($filePath);
  }
}
