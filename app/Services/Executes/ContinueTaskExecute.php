<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Models\MailingModel;
use App\Services\Authorization\Telegram;

class ContinueTaskExecute extends Execute
{
  const TYPE_ACTION = "send_message";
  const NAME_TASK = "continue_task";
  const LIMIT_ACTIONS = 35;
  const MAX_MSG = 5;
  protected array $users = [];
  protected string $msg = "";
  protected string $file = "";
  protected int $taskContinue;
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

  public function setTask(int $task)
  {
    $this->taskContinue = $task;

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
            ->where(["user" => $user->user, "task" => $this->taskContinue])
            ->update([
              "status" => 2,
            ]);
        } catch (\Exception $e) {
          $this->mailingModel
            ->where(["user" => $user->user, "task" => $this->taskContinue])
            ->update([
              "status" => 3,
            ]);
          ErrorHelper::writeToFile("$e\n");
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
        sleep(7);
      }
      echo "end";
      sleep(4);
    }

    return $this;
  }
}
