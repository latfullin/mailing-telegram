<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\TasksModel;
use App\Services\Authorization\Telegram;
use App\Services\Executes\ContinueTaskExecute;
use App\Services\Executes\MailingMessagesExecute;

class MailingMessagesController
{
  public function createTaskMailingMessages(ArgumentsHelpers $arguments, MailingMessagesExecute $execute)
  {
    $users = preg_split('/[\r\n]+/', $arguments->users, -1, PREG_SPLIT_NO_EMPTY);
    $users = count($users) === 0 ? $arguments->users : $users;
    $message = preg_replace('/[\r\n]+/', '\n', $arguments->msg);
    $execute
      ->setMsg($message)
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
