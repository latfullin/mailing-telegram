<?php

namespace App\Services\Executes;

use App\Helpers\CheckUsersHelpers;
use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class MailingMessagesExecute extends Execute
{
  const MAX_MSG = 10;
  private static ?MailingMessagesExecute $instance = null;
  protected string $msg;
  protected array $skipUsers = [];
  protected array $notFoundUser = [];
  protected bool $needCheckUsers = false;

  public static function instance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  public function execute(string $msg, array $users = [], bool $needCheckUsers = false)
  {
    $this->msg = $msg;
    $this->needCheckUsers = $needCheckUsers;

    if ($users) {
      $this->usersList = $users;
    }
    if ($this->validate()) {
      $this->getStart();
    }

    return $this;
  }

  private function __construct(array $userList = [])
  {
    parent::__construct();
    if ($userList) {
      $this->userList = $userList;
    }
  }

  private function getStart()
  {
    foreach ($this->sessionList as $session) {
      for ($i = 0; $i < self::MAX_MSG; $i++) {
        try {
          if (!$this->usersList) {
            break;
          }
          $user = array_pop($this->usersList);
          $this->sendMessage($session, $user, $this->msg);
          $this->success++;
        } catch (Exception $e) {
          array_push($this->skipUsers, $user);
          $this->amoutError++;
          ErrorHelper::writeToFile("$e\n");
          continue;
        }
      }
    }

    return $this;
  }


  private function validate()
  {
    try {
      if (is_string($this->msg) && strlen($this->msg) > 0) {
        echo "Msg: Ok\n";
      } else {
        throw new Exception('Not found text for msg');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }

    if (count($this->usersList) <= 0) {
      $this->initUsersInFile();
    }

    try {
      if ($this->needCheckUsers) {
        ['usersList' => $this->usersList, 'notFount' => $this->notFoundUsers]  = CheckUsersHelpers::checkEmptyUsers($this->usersList);
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }

    return true;
  }

  public function __destruct()
  {
    WorkingFileHelper::newTask($this->task, $this->usersList, $this->sessionList, $this->notFoundUser);
    WorkingFileHelper::endTask($this->task, $this->success, $this->amountError, $this->skipUsers);
  }
}
