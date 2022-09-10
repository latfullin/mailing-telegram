<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Models\MailingModel;
use App\Services\Authorization\Telegram;
// use Exception;

class ContinueTaskExecute extends Execute
{
  const TYPE_ACTION = "send_message";
  const NAME_TASK = "continue_task";
  const LIMIT_ACTIONS = 8;
  const MAX_MSG = 9;
  protected ?Telegram $telegram = null;
  protected array $users = [];
  protected string $msg = "";
  protected string $file = "";
  protected int $taskExecute;
  protected ?MailingModel $mailingModel = null;

  public function __construct(MailingModel $mailingModel)
  {
    $this->mailingModel = $mailingModel;
    parent::__construct(
      self::TYPE_ACTION,
      self::NAME_TASK,
      self::LIMIT_ACTIONS
    );
  }

  public function execute()
  {
    $this->getUsers();
    if ($this->users) {
      $this->modelTask
        ->where(["task" => $this->taskExecute])
        ->update(["status" => 1]);
      $this->updateStatus();
      $this->start();
    } else {
      $this->modelTask
        ->where(["task" => $this->taskExecute])
        ->update(["status" => 2]);
    }
    $this->modelTask->where(["task" => $this->task])->update(["status" => 2]);
  }

  private function start()
  {
    $uniq = 0;
    foreach ($this->sessionList as $session) {
      if (!$this->users) {
        break;
      }
      $this->initTelegram($session->phone);
      for ($i = 0; $i < self::MAX_MSG - $session->send_message; $i++) {
        $uniq++;
        try {
          if (!$this->users) {
            break;
          }
          $user = array_pop($this->users);
          print_r($user->user);
          if ($this->file) {
            $this->telegram->sendFoto(
              $user->user,
              $this->file,
              $this->msg . $uniq
            );
          } else {
            $this->telegram->sendMessage(
              $user->user,
              $uniq . $this->msg . $uniq
            );
          }
          $this->mailingModel
            ->where(["user" => $user->user, "task" => $this->taskExecute])
            ->update([
              "status" => 2,
            ]);
        } catch (\Exception $e) {
          $continue = $this->checkError($e, $user->user, $session->phone);
          if ($continue === "ban") {
            continue 2;
          }
          continue;
        }
        sleep(7);
      }
    }
  }

  private function updateStatus()
  {
    foreach ($this->users as $user) {
      $this->mailingModel
        ->where(["user" => $user->user, "task" => $this->task])
        ->update([
          "status" => 1,
        ]);
    }
  }

  public function initTelegram(string $phone)
  {
    try {
      $this->telegram = Telegram::instance($phone);
    } catch (\Exception $e) {
      ErrorHelper::writeToFile($e);
    }
  }

  public function getUsers()
  {
    $max = count($this->sessionList) * self::MAX_MSG;
    $this->users = $this->mailingModel
      ->where([
        "task" => $this->taskExecute,
        "status" => [0, 1],
      ])
      ->limit($max)
      ->get();
  }

  public function checkError(\Exception $error, $user, $phone)
  {
    ErrorHelper::writeToFile("$error\n");
    $this->mailingModel
      ->where(["user" => $user->user, "task" => $this->taskExecute])
      ->update([
        "status" => 3,
      ]);
    if ($error->getMessage() == "PEER_FLOOD") {
      $this->sessionConnect
        ->where(["phone" => $phone])
        ->update(["flood_wait" => true]);
      return "ban";
    }
    if ($error->getMessage() == "USER_DEACTIVATED_BAN") {
      $this->sessionConnect->where(["phone" => $phone])->update(["ban" => 1]);
      return "ban";
    }
    return "error_user";
  }

  public function setUsers(array $users): ContinueTaskExecute
  {
    $this->users = $users;

    return $this;
  }

  public function setMsg(string $msg): ContinueTaskExecute
  {
    $this->msg = $msg;

    return $this;
  }

  public function setFile(string $file): ContinueTaskExecute
  {
    $this->file = $file;

    return $this;
  }

  public function setTaskExecute(int $task)
  {
    $this->taskExecute = $task;

    return $this;
  }
}
