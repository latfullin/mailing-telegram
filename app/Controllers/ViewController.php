<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\PhoneModel;
use App\Models\ProxyModel;
use App\Models\TasksModel;
use App\Services\Authorization\Telegram;
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

  public function createSession(Menu $menu, ProxyModel $model)
  {
    $menu = $menu->getMenu();
    $proxy = $model->where(['active' => 1, 'who_used' => 0])->first();
    view('default', ['page' => 'create-session', 'title' => 'Created sessions', 'menu' => $menu, 'proxy' => $proxy]);
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

  // public function test(Menu $menu)
  // {
  //   $menu = $menu->getMenu();
  //   try {
  //     Telegram::instance(79874018497);
  //   } catch (\Exception $e) {
  //   }
  //   $data = Telegram::instance(79874018497)->sendMessage(
  //     '@hitThat',
  //     'Сегодня вечером свободна. Увидимся?\n\nПривет, я Лена 🙋‍♀️ - ассистент по работе с маркетплейсами\n\n🎯Наверняка ты уже запустил улётные товары на маркетплейс, но все еще не кайфанул от этого и я знаю почему.\n\n ⚓️Много мелких задач, важных для стабильных продаж не дают тебе расслабиться и тормозят масштабирование бизнеса.\n\nГотова спасти тебя от операционки и взять на себя рутинные задачи, которые отнимают у тебя время.\n\n 👩‍💻Почему именно я??? Все просто\n\n🔶Люблю, то что я делю\n🔶Активная\n🔶Коммуникабельная\n🔶 Ответственная\n🔶Быстро усваиваю информацию\n\n✅15 лет банковского опыта, знаю где и как найти деньги.\n✅Умею общаться с клиентами\n✅Владею анализом, в том числе MPstat\n✅Знаю как запускать рекламу\n✅Ориентируюсь в Личном кабинете WB\n✅Дружу с Excel\n✅Освоила Маркетинг и веб-дизайн\n\n📌Благодаря четкому регламенту, ты всегда будешь понимать, что я делаю и сможешь контролировать процесс, где бы ты не находился.\n\n🔋Я - жутко замотивирована, и поэтому знаю как мотивировать тебя, даже в самые сложные моменты.\n\n🔺Мое участие бесценно, но не бесплатно - от 10 000 в мес.\n\n🎁За оперативный ответ. Разбор карточки в подарок!\n \n🔝Пиши @elen_asistWB – мы точно сможем договори',
  //   );

  //   view('default', ['page' => 'test', 'title' => 'Check phones', 'menu' => $menu, 'data' => $data]);
  // }
}
