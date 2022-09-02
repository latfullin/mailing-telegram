<?php

namespace App\Services\Executes;

use App\Helpers\CheckUsersHelpers;
use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Models\MailingModel;
use App\Services\Authorization\Telegram;

class MailingMessagesExecute extends Execute
{
  const MAX_MSG = 13;
  const LIMIT_ACTIONS = 35;
  const TYPE_ACTION = "send_message";
  const NAME_TASK = "send_message";
  protected string $msg;
  protected mixed $photo = false;
  private array $users = [];
  protected ?MailingModel $mailingModel = null;

  /**
   * @param amountUsers count users the number of users to take from the database
   */
  public function execute(int $amountUsers)
  {
    $this->getUsers($amountUsers);
    if ($this->users) {
      $this->updateStatus();
      $this->getStart();
    }
  }

  public function __construct(MailingModel $mailingModel)
  {
    parent::__construct(
      self::TYPE_ACTION,
      self::NAME_TASK,
      self::LIMIT_ACTIONS
    );
    $this->mailingModel = $mailingModel;
  }

  // need methods define message type
  private function getStart()
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

          if ($this->photo) {
            $telegram->sendFoto(
              $user->user,
              $this->photo,
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
          print_r($e);
          $this->mailingModel
            ->where(["user" => $user->user, "task" => $this->task])
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
              ->update(["ban" => true]);
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

  private function getUsers(int $amountUsers)
  {
    $max = count($this->sessionList) * self::MAX_MSG;
    if ($max > $amountUsers) {
      $this->users = $this->mailingModel
        ->where(["task" => $this->task])
        ->limit($amountUsers)
        ->get();
    } else {
      $this->users = $this->mailingModel
        ->where(["task" => $this->task])
        ->limit($max)
        ->get();
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

  public function setUsers(array $users): MailingMessagesExecute
  {
    foreach ($users as $user) {
      $this->mailingModel->insert([
        "task" => $this->task,
        "user" => $user,
        "status" => 0,
      ]);
    }

    return $this;
  }

  public function setMsg(string $msg): MailingMessagesExecute
  {
    $this->msg = $msg;
    $this->modelTask->where(["task" => $this->task])->update([
      "information" => json_encode(
        ["msg" => $msg, "file" => $this->photo],
        JSON_UNESCAPED_UNICODE
      ),
    ]);

    return $this;
  }

  public function setPhoto(string $photo): MailingMessagesExecute
  {
    $this->photo = $photo;

    return $this;
  }
}
