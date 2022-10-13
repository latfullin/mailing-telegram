<?php

namespace App\Contracts\Enum;

interface EnumContract
{
  public static function getStatus(string $status);
  public static function getValue(int $status);
}
