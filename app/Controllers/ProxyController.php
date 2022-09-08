<?php

namespace App\Controllers;

use App\Helpers\ArgumentsHelpers;
use App\Models\ProxyModel;
use App\Services\Proxy\Ipv6Proxy;
use Carbon\Carbon;

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

  public function buyProxy(
    ArgumentsHelpers $arguments,
    Ipv6Proxy $ipv6,
    ProxyModel $model
  ) {
    $data = $ipv6->buyHttpProxy(
      $arguments->count,
      $arguments->period,
      $arguments->country
    );
    print_r($data);
    if ($data) {
      foreach ($data->list as $proxy) {
        $model->insert([
          "country" => $arguments->country,
          "address" => $proxy->host,
          "port" => $proxy->port,
          "login" => $proxy->user,
          "password" => $proxy->pass,
          "numeric_id" => $proxy->id,
          "active" => $proxy->active,
          "active_ad" => Carbon::now()->addDays($arguments->period),
        ]);
      }
    }
  }
}
