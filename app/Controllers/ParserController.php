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

  public function parseGroup(ParserExecute $parser): void
  {
    $filePath = $parser->channel('https://t.me/salikhov_invest')->executes()->save();
  }
}
