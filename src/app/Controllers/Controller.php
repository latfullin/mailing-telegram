<?php

namespace App\Controllers;

use App\Helpers\WorkingFileHelper;

class Controller
{
  protected array $sessionList;
  protected array $usersList = [];
  protected int $task;
  public int $successMsg = 0;
  public int $amoutError = 0;

  protected function __construct()
  {
    $this->sessionList = WorkingFileHelper::initSessionList();
    $this->task = WorkingFileHelper::lastTask();
  }

  public function setUsers(array $users): object
  {
    $this->usersList = $users;

    return $this;
  }
}
