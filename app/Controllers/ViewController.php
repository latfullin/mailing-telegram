<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\ProxyModel;

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
}
