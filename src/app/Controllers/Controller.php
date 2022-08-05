<?php

namespace App\Controllers;

use App\Helpers\WorkingFileHelper;

class Controller
{
  protected array $sessionList;
  protected int $task;
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
}
