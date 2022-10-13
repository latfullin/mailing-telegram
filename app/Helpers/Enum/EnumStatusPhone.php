<?php

namespace App\Helpers\Enum;

use App\Contracts\Enum\EnumContract;

enum EnumStatusPhone: int implements EnumContract
{
  case NotHired = 0;
  case TakenToWork = 1;
  case SuccessWork = 2;
  case ErrorAtWork = 3;
  case AllUsed = 10;
  case Technical = 11;

  public static function getStatus(string $status)
  {
    return match ($status) {
      'NotHired' => 0,
      'TakenToWork' => 1,
      'SuccessWork' => 2,
      'ErrorAtWork' => 3,
      'AllUsed' => 10,
      'Technical' => 11,
    };
  }

  public static function getValue(int $status)
  {
    return match ($status) {
      0 => 'Доступен',
      1 => 'Заблокирован',
      3 => 'Временные бан',
      10 => 'Общий',
      11 => 'Технический',
      default => 'Не известно',
    };
  }
}
