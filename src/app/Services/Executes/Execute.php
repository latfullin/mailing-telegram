<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class Execute
{
  /**
   * @param sessionList phone list instance.  
   */
  protected array $sessionList;

  /**
   * @param usedSession used phone number in instance.
   */
  protected array $usedSession = [];

  /**
   * @param task Param init automatic.  
   */
  protected int $task;

  /**
   * @param usersList list users for executes.
   */
  protected array $usersList = [];

  /**
   * @param success number of successful iterations.
   */
  public int $success = 0;

  /**
   * @param amountError number of error iterationTes.
   */

  public int $amountError = 0;


  /**
   * @param valiteUsers validate users on the existence
   */
  protected bool $valiteUsers = false;


  /**
   * @param phone hand over param if need init certain phones number, else will use phone is name 'phone';
   */
  protected function __construct(array $phone = [])
  {
    if ($phone) {
      $this->sessionList = $phone;
    } else {
      echo 'esto';
      $this->sessionList = WorkingFileHelper::initSessionList();
    }
    $this->task = WorkingFileHelper::lastTask();
  }

  /**
   * Set users list for executes, if not hand over, then will be used file 'user'.
   */
  public function setUsers(array $users): object
  {
    $this->usersList = $users;
    $this->valiteUsers = false;

    return $this;
  }

  public function usedSession(string $session): void
  {
    if ($this->sessionList) {
      array_push($this->usedSession, array_splice($this->sessionList, array_search($session, $this->sessionList), 1)[0]);
    }
  }

  /**
   * init file with users
   */
  public function initUsersInFile(): bool
  {
    $this->usersList = WorkingFileHelper::initUsersList();
    if ($this->usersList) {
      return true;
    }
    return false;
  }

  protected function methodsWithChallen(string $session, string $method, string $link): void
  {
    try {
      if ($method === 'leaveChannel' || $method === 'joinChannel') {
        Telegram::instance($session)->{$method}($link);
      } else {
        throw new Exception('Not found methods');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }

  protected function verifyChannel($channel): object|array
  {
    try {
      if ($channel) {
        return Telegram::instance($this->sessionList[rand(0, count($this->sessionList) - 1)])->getChannel($channel);
      } else {
        throw new Exception('Not found channel to invite!');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }

  protected function sendMessage(string $session, string $link, string  $msg): void
  {
    Telegram::instance($session)->sendMessage($link, $msg);
  }
}
