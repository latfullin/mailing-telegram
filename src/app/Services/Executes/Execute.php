<?php

namespace App\Services\Executes;

use App\Helpers\WorkingFileHelper;

class Execute
{
  protected array $sessionList;
  protected int $task;
  protected array $usersList = [];
  public int $success = 0;
  public int $amoutError = 0;

  protected function __construct(array $phone = [])
  {
    if ($phone) {
      $this->sessionList = $phone;
    } else {
      $this->sessionList = WorkingFileHelper::initSessionList();
    }
    $this->task = WorkingFileHelper::lastTask();
  }

  public function setUsers(array $users): object
  {
    $this->usersList = $users;

    return $this;
  }

  public static function initUsersInFile(): bool
  {
    self::$usersList = WorkingFileHelper::initUsersList();
    if (self::$usersList) {
      return true;
    }
    return false;
  }
}
