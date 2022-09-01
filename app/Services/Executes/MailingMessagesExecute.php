<?php

namespace App\Services\Executes;

use App\Helpers\CheckUsersHelpers;
use App\Helpers\ErrorHelper;
use App\Helpers\WorkingFileHelper;
use App\Models\MailingModel;

class MailingMessagesExecute extends Execute
{
  const MAX_MSG = 20;
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
    parent::__construct(self::TYPE_ACTION, self::NAME_TASK);
    $this->mailingModel = $mailingModel;
  }

  // need methods define message type
  private function getStart()
  {
    $uniq = 0;
    foreach ($this->sessionList as $session) {
      for ($i = 0; $i < self::MAX_MSG; $i++) {
        $uniq++;

        print_r($this->users);
        die();
        try {
          if (!$this->users) {
            break;
          }
          $user = array_pop($this->users);
          $this->sendMessage(
            $session->phone,
            $user->user,
            $uniq . $this->msg . $uniq
          );
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
              "error_log" => $e->getMessage(),
            ]);
          ErrorHelper::writeToFile("$e\n");
          continue;
        }
      }
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
    $this->modelTask
      ->where(["task" => $this->task])
      ->update(["information" => $msg]);

    return $this;
  }

  public function setPhoto(string $photo): MailingMessagesExecute
  {
    $this->photo = $photo;

    return $this;
  }
}
