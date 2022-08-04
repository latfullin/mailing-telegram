<?php

namespace App\Controllers;

use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Services\Authorization\Telegram;
use Exception;

class MailingMessagesController extends Controller
{
  private static ?MailingMessagesController $instance = null;
  protected array $usersList = [];
  protected string $msg;
  protected array $sessionList;
  protected array $skipUsers = [];
  public int $successMsg = 0;
  public int $amoutError = 0;

  public static function init()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct()
  {
    $this->sessionList = WorkingFileHelper::initSessionList();
  }

  private function getStart($maxMsg = 10)
  {
    $task = WorkingFileHelper::newTask($this->usersList, $this->sessionList);
    foreach ($this->sessionList as $session) {
      $user = '';
      try {
        for ($i = 0; $i < $maxMsg; $i++) {
          if (!$this->usersList) {
            break;
          }
          $user = array_pop($this->usersList);
          Telegram::instance($session)->sendMessage($user, $this->msg);
          $this->successMsg++;
        }
      } catch (Exception $e) {
        array_push($this->skipUsers, $user);
        $this->amoutError++;
        ErrorHelper::writeToFile("$e\n");
        continue;
      }
    }

    $task = WorkingFileHelper::endTask($task, $this->successMsg, $this->amoutError, $this->skipUsers);
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

  public function setUsers(array $users)
  {
    $this->usersList = $users;

    return $this;
  }


  private function validate()
  {
    try {
      if (is_string($this->msg) && strlen($this->msg) > 0) {
        echo "Msg: Ok\n";
      } else {
        throw new ('Send text error');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }

    try {
      if (count($this->usersList) > 0) {
        echo "Users: Ok\n";
      } else {
        echo "Users: Warning\n";
        $this->usersList = WorkingFileHelper::initUsersList();
      }
      if (count($this->usersList) > 0) {
        true;
      } else {
        throw new ('Users list empty');
      }
    } catch (Exception $e) {
      ErrorHelper::writeToFileAndDie("$e\n");
    }

    return true;
  }
}
