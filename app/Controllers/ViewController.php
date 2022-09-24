<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\ProxyModel;
use App\Models\TasksModel;

class ViewController
{
  public function viewProxy(ArgumentsHelpers $argument, ProxyModel $proxyModel)
  {
    $proxy['all'] = count($proxyModel->get());
    $proxy['active'] = count($proxyModel->where(['active' => 1])->get());
    $proxy['not_used'] = count($proxyModel->where(['active' => 1, 'who_used' => 0])->get());
    view('default', ['page' => $argument->page, 'title' => 'Proxy', 'proxy' => $proxy]);
  }

  public function sendMessage(ArgumentsHelpers $argument)
  {
    view('default', ['page' => $argument->page, 'title' => 'Send Message For Telegram']);
  }
  public function task(ArgumentsHelpers $argument, TasksModel $tasksModel)
  {
    $tasks = $tasksModel
      ->orderByDesc('task')
      ->where("type != 'continue_task'")
      ->get();
    $tasks = array_map(
      fn($i) => [
        'task' => $i->task,
        'information' => @json_decode($i->information),
        'status' => $i->status,
        'type' => $i->type,
      ],
      $tasks,
    );
    view('default', ['page' => $argument->page, 'title' => 'Task list', 'task' => $tasks]);
  }

  public function createdTask(ArgumentsHelpers $argument)
  {
    view('default', ['page' => $argument->page, 'title' => 'Created task']);
  }
}
