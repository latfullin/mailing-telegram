<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\ProxyModel;

class ProxyController
{
  private $polyfills = ["socks" => "\SocksProxy"];

  public function addProxy(ArgumentsHelpers $arguments, ProxyModel $model)
  {
    $model->insert([
      "type" => $this->polyfills[$arguments->type],
      "address" => $arguments->address,
      "port" => $arguments->port,
      "password" => $arguments->password ?? "",
      "ipv" => $arguments->ipv ?? "",
      "active" => true,
      "active_at" => $arguments->activeTime,
    ]);
  }
}
