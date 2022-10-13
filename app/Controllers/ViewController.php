<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Models\ProxyModel;
use App\Models\TasksModel;
use App\View\Components\Menu\Menu;

class ViewController
{
  public function viewProxy(ArgumentsHelpers $argument, ProxyModel $proxyModel, Menu $menu)
  {
    try {
      $menu = $menu->getMenu();
      $proxy['all'] = count($proxyModel->get());
      $proxy['active'] = count($proxyModel->where(['active' => 1])->get());
      $proxy['not_used'] = count($proxyModel->where(['active' => 1, 'who_used' => 0])->get());
      view('default', ['page' => $argument->page, 'title' => 'Proxy', 'proxy' => $proxy, 'menu' => $menu]);
    } catch (\Exception $e) {
    }
  }

  public function sendMessage(ArgumentsHelpers $argument, Menu $menu)
  {
    $menu = $menu->getMenu();

    view('default', ['page' => $argument->page, 'title' => 'Send Message For Telegram', 'menu' => $menu]);
  }
  public function task(ArgumentsHelpers $argument, TasksModel $tasksModel, Menu $menu)
  {
    $menu = $menu->getMenu();
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

    view('default', ['page' => $argument->page, 'title' => 'Task list', 'task' => $tasks, 'menu' => $menu]);
  }

  public function createdTask(ArgumentsHelpers $argument, Menu $menu)
  {
    $menu = $menu->getMenu();

    view('default', ['page' => $argument->page, 'title' => 'Created task', 'menu' => $menu]);
  }

  public function sessions(ArgumentsHelpers $argument, PhoneModel $phone, Menu $menu)
  {
    $menu = $menu->getMenu();
    $phones = $phone->get();

    view('default', ['page' => $argument->page, 'title' => 'Sessions list', 'phones' => $phones, 'menu' => $menu]);
  }

  public function login(ArgumentsHelpers $argument, Menu $menu)
  {
    $menu = $menu->getMenu();

    view('default', ['page' => $argument->page, 'title' => 'Login', 'menu' => $menu]);
  }

  public function home(Menu $menu)
  {
    $menu = $menu->getMenu();

    view('default', ['page' => 'login', 'title' => 'Login', 'menu' => $menu]);
  }

  public function registration(Menu $menu)
  {
    $menu = $menu->getMenu();

    view('default', ['page' => 'registration', 'title' => 'Registration', 'menu' => $menu]);
  }

  public function createSession(Menu $menu)
  {
    $menu = $menu->getMenu();

    view('default', ['page' => 'create-session', 'title' => 'Created sessions', 'menu' => $menu]);
  }

  public function notFound(Menu $menu)
  {
    $menu = $menu->getMenu();

    view('default', ['page' => '404', 'title' => 'Not found', 'menu' => $menu], 404);
  }

  public function checkPhones(Menu $menu)
  {
    $menu = $menu->getMenu();

    view('default', ['page' => 'check-phones', 'title' => 'Check phones', 'menu' => $menu]);
  }
}
