<?php

namespace App\Helpers;

use App\Services\Authorization\Telegram;

class CheckUsersHelpers
{
  const ONE_MONTH = 2629743;
  const TWO_MONTH = 5259486;
  private static array $notFoundUsers = [];
  private static array $successUsersList = [];
  private static array $usersList = [];
  private static int $today;

  public static function checkEmptyUsers(array $usersList): array
  {
    self::$usersList = $usersList;
    self::$today = time();
    $phone = WorkingFileHelper::initcheckSession();
    foreach (self::$usersList as $user) {
      try {
        $result = Telegram::instance($phone[0])->getInfo($user);
        if ($result !== false) {
          if ($result['User']['status']['was_online'] > (self::$today - self::TWO_MONTH)) {
            self::successArray($user);
            continue;
          }
        }
        self::notFoundArray($user);
      } catch (\Exception $e) {
        self::notFoundArray($user);
        continue;
      }
    }

    return ['usersList' => self::$successUsersList, 'notFount' => self::$notFoundUsers];
  }

  private static function notFoundArray(string $user): void
  {
    array_push(self::$notFoundUsers, array_splice(self::$usersList, array_search($user, self::$usersList), 1)[0]);
  }

  private static function successArray(string $user): void
  {
    array_push(self::$successUsersList, array_splice(self::$usersList, array_search($user, self::$usersList), 1)[0]);
  }
}
