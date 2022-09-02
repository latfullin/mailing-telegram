<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\MailingModel;
use App\Models\TasksModel;
use App\Services\Executes\ContinueTaskExecute;
use App\Services\Executes\MailingMessagesExecute;

class MailingMessagesController
{
  public function createMailingMessages(
    ArgumentsHelpers $arguments,
    MailingMessagesExecute $execute
  ) {
    $execute
      ->setMsg($arguments->msg)
      ->setPhoto($arguments->photo ?? false)
      ->setUsers($arguments->users)
      ->execute($arguments->limit);
  }

  public function continueTask(
    ArgumentsHelpers $arguments,
    TasksModel $tasksModel,
    MailingModel $mailingModel,
    ContinueTaskExecute $continue
  ) {
    $task = $tasksModel->where(["task" => $arguments->task])->first();
    $users = $mailingModel
      ->where([
        "task" => $task["task"],
        "status" => [0, 1],
      ])
      ->get();

    $information = json_decode($task["information"], JSON_UNESCAPED_UNICODE);
    $continue
      ->setUsers($users)
      ->setMsg($information["msg"])
      ->setFile($information["file"])
      ->start();
  }
}
