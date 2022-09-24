<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\TasksModel;
use App\Services\Executes\ContinueTaskExecute;
use App\Services\Executes\MailingMessagesExecute;

class MailingMessagesController
{
  public function createTaskMailingMessages(ArgumentsHelpers $arguments, MailingMessagesExecute $execute)
  {
    $users = preg_split('/[\r\n]+/', $arguments->users, -1, PREG_SPLIT_NO_EMPTY);
    $execute
      ->setMsg($arguments->msg)
      ->setFile($arguments->file ?? false)
      ->setUsers($users);
  }

  public function continueTask(ArgumentsHelpers $arguments, TasksModel $tasksModel, ContinueTaskExecute $continue)
  {
    $task = $tasksModel->where(['task' => $arguments->task])->first();

    $continue
      ->setTaskExecute($task['task'])
      ->setMsg($arguments->msg)
      ->setFile($arguments->photo ?? '')
      ->execute();
  }
}
