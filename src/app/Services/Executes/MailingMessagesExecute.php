<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class MailingMessagesExecute extends Execute
{
  private static ?MailingMessagesExecute $instance = null;
  protected string $msg;
  protected array $skipUsers = [];

  public static function instance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct(array $userList = [])
  {
    parent::__construct();
    if ($userList) {
      $this->userList = $userList;
    }
  }

  private function getStart($maxMsg = 10)
  {
    WorkingFileHelper::newTask($this->task, $this->usersList, $this->sessionList);
    foreach ($this->sessionList as $session) {
      $user = '';
      for ($i = 0; $i < $maxMsg; $i++) {
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

  public function mailingMessagesUsers(string $msg, array|string $users = [])
  {
    $this->msg = $msg;
    if (count($users) > 0) {
      $this->usersList = $users;
    }
    if ($this->validate()) {
      $this->getStart();
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

    try {
      if (count($this->usersList) > 0) {
        echo "Users: Ok\n";
      } else {
        echo "Users: Warning\n";
        parent::initUsersInFile();
      }

      if (count($this->usersList) > 0) {
        true;
      } else {
        throw new Exception('Users list empty');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }

    return true;
  }

  public function __destruct()
  {
    print_r($this->skipUsers);
    WorkingFileHelper::newTask($this->task, $this->usersList);
    WorkingFileHelper::endTask($this->task, $this->success, $this->amountError, $this->skipUsers);
  }
}
