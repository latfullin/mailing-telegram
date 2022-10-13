<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Services\Executes\ParserTelephoneExecute;

class CheckItPhonesController
{
  public function checkItPhones(ArgumentsHelpers $argument, ParserTelephoneExecute $parser)
  {
    // print_r($parser);
    $phones = preg_split('/[\r\n]+/', $argument->phones, -1, PREG_SPLIT_NO_EMPTY);

    $parser->checkPhones($phones)->save();
    return response('Success');
  }
}
