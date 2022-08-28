<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Models\PhoneModel;
use App\Services\Authorization\Telegram;

class Execute
{
  /**
   * @param sessionList phone list instance.  
   */
  protected array $sessionList;

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
  protected bool $validateUsers = false;


  /**
   * @param phone hand over param if need init certain phones number, else will use phone is name 'phone';
   */
  protected function __construct(array $phone = [])
  {
    if ($phone) {
      $this->sessionList = $phone;
    } else {
      $phone = new PhoneModel();
      $this->sessionList = $phone->where(['ban' => 0])->get();
    }

    $this->task = WorkingFileHelper::lastTask();
  }

  /**
   * init file with users
   */
  protected function initUsersInFile(): bool
  {
    try {
      $this->usersList = WorkingFileHelper::initUsersList();
      if ($this->usersList) {
        return true;
      } else {
        throw new \Exception('Users list empty');
      }
    } catch (\Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }

    return false;
  }

  protected function methodsWithChallen(string $session, string $method, string $link): void
  {
    try {
      if ($method === 'leaveChannel' || $method === 'joinChannel') {
        Telegram::instance($session)->{$method}($link);
      } else {
        throw new \Exception('Not found methods');
      }
    } catch (\Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }
  }

  protected function verifyChannel($channel): object|array
  {
    try {
      if ($channel) {
        return Telegram::instance('79874018497')->getChannel($channel);
      } else {
        throw new \Exception('Not found channel to invite!');
      }
    } catch (\Exception $e) {
      if ($e->getMessage() == 'You have not joined this chat') {
        return Telegram::instance('79874018497')->joinChannel($channel)->getChannel($channel);
      }
      ErrorHelper::writeToFileAndDie($e);
    }
  }

  protected function sendMessage(string $session, string $addressMessage, string  $msg): void
  {
    Telegram::instance($session)->sendMessage($addressMessage, $msg);
  }

  public function setChannel(string $channel)
  {
    $this->channel = $channel;

    return $this;
  }

  /**
   * Set users list for executes, if not hand over, then will be used file 'user'.
   */
  public function setUsers(array $users): object
  {
    $this->usersList = $users;
    $this->validateUsers = false;

    return $this;
  }
}
