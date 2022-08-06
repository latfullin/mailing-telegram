<?php

namespace App\Helpers;

class ErrorHelper
{
  public static function writeToFileAndDie($text)
  {
    file_put_contents('ExceptionLog.log', $text, FILE_APPEND);
    echo $text;
    die();
  }

  public static function writeToFile($text)
  {
    file_put_contents('ExceptionLog.log', $text, FILE_APPEND);
    echo $text;
  }
}
