<?php

namespace App\Services\Executes;

use App\Helpers\ErrorHelper;
use App\Models\MailingModel;
use App\Services\Authorization\Telegram;

class MailingMessagesExecute extends Execute
{
  const LIMIT_ACTIONS = 35;
  const TYPE_ACTION = "send_message";
  const NAME_TASK = "create_task_send_message";

  protected string $msg;
  protected mixed $file = false;
  protected ?MailingModel $mailingModel = null;

  public function __construct(MailingModel $mailingModel)
  {
    parent::__construct(self::TYPE_ACTION, self::NAME_TASK);
    $this->mailingModel = $mailingModel;
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
        ["msg" => $msg, "file" => $this->file],
        JSON_UNESCAPED_UNICODE
      ),
    ]);

    return $this;
  }

  public function setFile(string $file): MailingMessagesExecute
  {
    $this->file = $file;

    return $this;
  }
}
