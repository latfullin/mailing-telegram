<?php

namespace App\Services\Executes;

use App\Helpers\Enum\EnumStatus;
use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Models\PhoneModel;
use App\Models\TasksModel;
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

  protected ?PhoneModel $sessionConnect = null;
  protected ?TasksModel $modelTask = null;
  protected string $typeAction = '';
  protected string $nameTask = 'empty';
  protected int $limitActions = 10;

  /**
   * @param phone hand over param if need init certain phones number, else will use phone is name 'phone';
   */
  public function __construct(
    string $typeAction = '',
    string $nameTask = '',
    int $limitActions = 10,
    string $howUsed = 'AllUsed',
  ) {
    $this->typeAction = $typeAction ? $typeAction : 'count_action';
    $this->nameTask = $nameTask;
    $this->limitActions = $limitActions;
    $this->sessionConnect = new PhoneModel();
    $this->getSessionList($howUsed);
    $this->newTask();
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

  protected function getSessionList(string $howUsed = 'AllUsed'): void
  {
    $this->sessionList = $this->sessionConnect
      ->limit(10)
      ->sessionList($this->typeAction, EnumStatus::getStatus($howUsed), $this->limitActions);
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
        $this->incrementActions($this->sessionList[0]->phone);
        return Telegram::instance($this->sessionList[0]->phone)->getChannel($channel);
      } else {
        throw new \Exception('Not found channel to invite!');
      }
    } catch (\Exception $e) {
      if ($e->getMessage() == 'You have not joined this chat') {
        $this->incrementActions($this->sessionList[0]->phone);
        return Telegram::instance($this->sessionList[0]->phone)
          ->joinChannel($channel)
          ->getChannel($channel);
      }
      ErrorHelper::writeToFileAndDie($e);
    }
  }

  protected function sendMessage(string $session, string $addressMessage, string $msg, $photo = false): void
  {
    if ($photo) {
      Telegram::instance($session)->sendFoto($addressMessage, $photo, $msg);
    } else {
      Telegram::instance($session)->sendMessage($addressMessage, $msg);
    }
    $this->incrementActions($session);
  }

  public function setChannel(string $channel)
  {
    $this->channel = $channel;

    return $this;
  }

  public function newTask()
  {
    $this->modelTask = new TasksModel();
    $this->modelTask->insert(['type' => $this->nameTask]);
    $this->task = $this->modelTask->getLastTask()['task'];
  }

  public function incrementActions(string $phone): void
  {
    $this->sessionConnect->increment($phone, $this->typeAction);
  }

  // start client in process cpu. If need look, write in sh console command "top".
  protected function startClient(string $phone): void
  {
    Telegram::instance($phone);
  }
}
