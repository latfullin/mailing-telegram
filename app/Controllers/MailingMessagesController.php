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
    ContinueTaskExecute $continue,
    MailingModel $mailingModel
  ) {
    $task = $tasksModel->where(["task" => $arguments->task])->first();
    $users = $mailingModel
      ->where([
        "task" => $task["task"],
        "status" => [0, 1],
      ])
      ->get();

    $continue
      ->setUsers($users)
      ->setMsg($arguments->msg)
      ->setTask($task["task"])
      ->setFile($arguments->photo)
      ->start();
  }
}
