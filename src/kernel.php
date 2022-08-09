<?php

use App\Helpers\LangHelper;

require_once 'vendor/autoload.php';


function timeLang($type)
{
  return LangHelper::init($type);
}
