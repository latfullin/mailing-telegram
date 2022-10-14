<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Services\Authorization\Telegram;
use App\Services\Executes\ParserTelephoneExecute;

class CheckItPhonesController
{
  public function checkItPhones(ArgumentsHelpers $argument, ParserTelephoneExecute $parser)
  {
    $phones = preg_split('/[\r\n]+/', $argument->phones, -1, PREG_SPLIT_NO_EMPTY);
    $parser->checkPhones($phones)->save();
    return response('Success');
  }

  public function test(ArgumentsHelpers $argument, ParserTelephoneExecute $parser)
  {
    $a = Telegram::instance(79874018497)->getInformationByNumber($argument->phone);
    return response($a);
  }
}
