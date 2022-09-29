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
    $task = $tasksModel?->where(['task' => $arguments->task])?->first();
    if (!$task) {
      return response('Not found task');
    }
    if ($task['status'] === 0) {
      $tasksModel->where(['task' => $arguments->task])->update(['status' => 1]);
    }
    $data = json_decode($task['information']);
    $continue
      ?->setTaskExecute($task['task'])
      ?->setMsg($data->msg)
      ?->setFile($data?->file ?? '')
      ?->execute();
    if (!$continue) {
      return response('Error');
    }

    return response($continue);
  }
}
