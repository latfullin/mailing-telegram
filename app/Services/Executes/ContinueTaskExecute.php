<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Services\Authorization\Telegram;

class ContinueTaskExecute extends Execute
{
  const TYPE_ACTION = "send_message";
  const NAME_TASK = "continue_task";
  const LIMIT_ACTIONS = 35;
  const MAX_MSG = 13;
  protected array $users = [];
  protected string $msg = "";
  protected string $file = "";

  public function __constuct()
  {
    parent::__construct(
      self::TYPE_ACTION,
      self::NAME_TASK,
      self::LIMIT_ACTIONS
    );
  }

  public function setUsers(array $users): ContinueTaskExecute
  {
    $this->users = $users;

    return $this;
  }

  public function setMsg(string $msg)
  {
    $this->msg = $msg;

    return $this;
  }

  public function setFile(string $file)
  {
    $this->file = $file;

    return $this;
  }

  public function start()
  {
    $uniq = 0;
    foreach ($this->sessionList as $session) {
      if (!$this->users) {
        break;
      }

      $telegram = Telegram::instance($session->phone);
      for ($i = 0; $i < self::MAX_MSG; $i++) {
        $uniq++;
        try {
          if (!$this->users) {
            break;
          }
          $user = array_pop($this->users);

          if ($this->file) {
            $telegram->sendFoto(
              $user->user,
              $this->file,
              $uniq . $this->msg . $uniq
            );
          } else {
            $telegram->sendMessage($user->user, $uniq . $this->msg . $uniq);
          }

          $this->mailingModel
            ->where(["user" => $user->user, "task" => $this->task])
            ->update([
              "status" => 2,
            ]);
        } catch (\Exception $e) {
          $this->mailingModel
            ->where(["user" => $user->user, "task" => $this->task])
            ->update([
              "status" => 3,
            ]);
          ErrorHelper::writeToFile("$e\n");
          print_r($e);
          if ($e->getMessage() == "PEER_FLOOD") {
            $this->sessionConnect
              ->where(["phone" => $session->phone])
              ->update(["flood_wait" => true]);
            continue 2;
          }
          if ($e->getMessage() == "USER_DEACTIVATED_BAN") {
            $this->sessionConnect
              ->where(["phone" => $session->phone])
              ->update(["ban" => 1]);
            continue 2;
          }
          continue;
        }
        sleep(5);
      }

      sleep(4);
    }

    return $this;
  }
}
