<?php

namespace App\Helpers;

class LangHelper
{
  public static function init($type)
  {
    $time = include 'src/lang/ru/time.php';
    return $time[$type] ?? false;
  }
}
