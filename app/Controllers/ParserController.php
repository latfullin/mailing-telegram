<?php

namespace App\Controllers;

use App\Services\Bot\SendMessageBot;
use App\Services\Executes\ParserExecute;
use App\Services\Executes\ParserTelephoneExecute;

class ParserController
{
  public function checkPhone(array|object $phones): void
  {
    $parser = new ParserTelephoneExecute(false, true);
    $filePath = $parser->checkPhones($phones)->usersProcessing()->save();
  }

  public function parseGroup(string $channel): void
  {
    $filePath = ParserExecute::instance(false, true)->channel($channel)->executes()->save();
    echo 'end';
  }
}
